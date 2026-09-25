<?php

namespace App\Console\Commands;

use App\Mail\BookingReminder;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Emails the day-before reminder for every stay arriving tomorrow.
 *
 * Meant to be run once a day by cron. It is safe to run more often than that:
 * each booking is stamped once it has been reminded, so a second run in the
 * same day sends nothing.
 */
class SendBookingReminders extends Command
{
    protected $signature = 'bookings:send-reminders
                            {--days=1 : How many days before arrival to send}
                            {--dry-run : List who would be emailed without sending}';

    protected $description = 'Send the arrival reminder to guests checking in tomorrow';

    public function handle(): int
    {
        $days = max(0, (int) $this->option('days'));
        $target = now()->startOfDay()->addDays($days);

        $orders = Order::with(['customer', 'items'])
            ->where('payment_status', 'paid')
            ->whereNotIn('checkout_status', ['cancelled', 'checked_in', 'checked_out'])
            ->whereNull('reminder_sent_at')
            // Arriving on the target day. A range, not whereDate(), so the
            // check_in index can still be used.
            ->whereHas('items', function ($q) use ($target) {
                $q->whereBetween('check_in', [$target->toDateString(), $target->copy()->endOfDay()->toDateTimeString()]);
            })
            ->get()
            // A booking is reminded on its own first night, not on the first
            // night of any room it happens to contain.
            ->filter(fn (Order $order) => $order->items->min('check_in')
                && \Carbon\Carbon::parse($order->items->min('check_in'))->isSameDay($target));

        if ($orders->isEmpty()) {
            $this->info('No stays arriving on ' . $target->toDateString() . ' need a reminder.');

            return self::SUCCESS;
        }

        $sent = 0;
        $skipped = 0;

        foreach ($orders as $order) {
            $email = $order->customer_id ? optional($order->customer)->email : $order->guest_email;

            if (!$email) {
                $this->warn('  ' . $order->order_number . ' — no email address, skipped');
                $skipped++;
                continue;
            }

            if ($this->option('dry-run')) {
                $this->line('  would email ' . $email . ' about ' . $order->order_number);
                $sent++;
                continue;
            }

            try {
                Mail::to($email)->send(new BookingReminder($order));

                // Stamp only after the send succeeds, so a failure is retried
                // by tomorrow's run rather than silently dropped.
                $order->reminder_sent_at = now();
                $order->save();

                $this->line('  sent to ' . $email . ' for ' . $order->order_number);
                $sent++;
            } catch (\Throwable $e) {
                Log::error('Reminder email failed for ' . $order->order_number . ': ' . $e->getMessage());
                $this->error('  ' . $order->order_number . ' — ' . $e->getMessage());
                $skipped++;
            }
        }

        $this->info(($this->option('dry-run') ? 'Would send ' : 'Sent ') . $sent . ' reminder(s)'
            . ($skipped ? ', ' . $skipped . ' skipped' : '') . ' for ' . $target->toDateString() . '.');

        return self::SUCCESS;
    }
}
