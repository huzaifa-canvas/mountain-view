<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Read-only gallery of the transactional emails the site sends, so an admin
 * can see exactly what lands in a guest's inbox without placing a booking.
 */
class EmailTemplates extends Controller
{
    /** How many bookings the preview picker offers at once. */
    private const PICKER_LIMIT = 25;

    /**
     * Every mailable the application sends, with the context an admin needs
     * to understand when it goes out and who receives it.
     */
    public static function catalogue(): array
    {
        return [
            'booking-confirmation' => [
                'name'      => 'Booking confirmation',
                'mailable'  => \App\Mail\BookingConfirmation::class,
                'view'      => 'emails.booking_confirmation',
                'audience'  => 'Guest who booked',
                'icon'      => 'bi-check2-circle',
                'tone'      => 'is-green',
                'summary'   => 'Confirms the stay and invites the guest to join the membership programme.',
                'trigger'   => 'Sent automatically the moment a Stripe payment succeeds and the order is created.',
                'origin'    => 'Front\\Ecommerce::processPayment()',
                'automatic' => true,
            ],
            'admin-new-booking' => [
                'name'      => 'New booking alert',
                'mailable'  => \App\Mail\AdminNewBooking::class,
                'view'      => 'emails.admin_new_booking',
                'audience'  => 'Motel admin',
                'icon'      => 'bi-bell',
                'tone'      => 'is-gold',
                'summary'   => 'Internal notice with the guest details and totals for a fresh booking.',
                'trigger'   => 'Sent alongside the guest confirmation, to the address in Global Setting.',
                'origin'    => 'Front\\Ecommerce::processPayment()',
                'automatic' => true,
            ],
            'booking-reminder' => [
                'name'      => 'Stay reminder',
                'mailable'  => \App\Mail\BookingReminder::class,
                'view'      => 'emails.booking_reminder',
                'audience'  => 'Guest who booked',
                'icon'      => 'bi-envelope-paper',
                'tone'      => 'is-blue',
                'summary'   => 'A gentle nudge ahead of the arrival date with the check-in details.',
                'trigger'   => 'Sent manually from an order\'s detail page using "Send reminder email".',
                'origin'    => 'Admin\\AdminOrders::sendReminder()',
                'automatic' => false,
            ],
            'guest-thank-you' => [
                'name'      => 'Thank you & feedback',
                'mailable'  => \App\Mail\GuestThankYou::class,
                'view'      => 'emails.guest_thankyou',
                'audience'  => 'Guest who booked',
                'icon'      => 'bi-chat-heart',
                'tone'      => '',
                'summary'   => 'Thanks the guest after departure and links to the feedback form.',
                'trigger'   => 'Sent when an order is marked "Checked out" in the admin.',
                'origin'    => 'Admin\\AdminOrders::markCheckedOut()',
                'automatic' => false,
            ],
        ];
    }

    public function index()
    {
        $templates = self::catalogue();
        $sampleOrder = $this->sampleOrder();

        // Show each template's real subject line, built from the same mailable
        // the application uses when it sends for real.
        foreach ($templates as $key => $template) {
            $templates[$key]['subject'] = $this->subjectFor($template['mailable'], $sampleOrder);
            $templates[$key]['key'] = $key;
        }

        $general_setting = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $adminEmail = $general_setting->general_setting_email ?? config('mail.from.address');
        $mailer = config('mail.default');

        return view('admin.emails.index', compact('templates', 'adminEmail', 'mailer'));
    }

    public function show(Request $request, string $key)
    {
        $template = $this->templateOrFail($key);

        $order = $this->resolveOrder($request->query('order'));
        $template['subject'] = $this->subjectFor($template['mailable'], $order);
        $template['key'] = $key;

        $search = trim((string) $request->query('q', ''));
        $orders = $this->pickableOrders($search, $order);

        $usingSample = !$order->exists;

        return view('admin.emails.show', compact('template', 'order', 'orders', 'usingSample', 'search'));
    }

    /**
     * Bookings offered in the "preview with a booking" picker.
     *
     * The list is always capped, never the whole table: without a search it is
     * the newest few, and with one it is the best matches. The order currently
     * being previewed is pinned on so the picker cannot disagree with the
     * preview when an older booking is opened by its id.
     */
    private function pickableOrders(string $search, Order $current)
    {
        $query = Order::query()
            // id, not created_at: the primary key is indexed, so this stays a
            // cheap index read however many bookings the table holds.
            ->orderByDesc('id')
            ->limit(self::PICKER_LIMIT);

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('order_number', 'like', $like)
                  ->orWhere('guest_name', 'like', $like)
                  ->orWhere('guest_email', 'like', $like)
                  ->orWhereHas('customer', function ($c) use ($like) {
                      $c->where('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhere('email', 'like', $like);
                  });
            });
        }

        $orders = $query->get(['id', 'order_number', 'guest_name', 'customer_id']);

        if ($current->exists && !$orders->contains('id', $current->id)) {
            $orders->prepend($current);
        }

        return $orders;
    }

    /**
     * The email itself, rendered exactly as the mailable would send it.
     * Loaded inside an iframe so its styles cannot leak into the admin theme.
     */
    public function render(Request $request, string $key)
    {
        $template = $this->templateOrFail($key);
        $order = $this->resolveOrder($request->query('order'));

        $mailable = new $template['mailable']($order);

        return response($mailable->render())
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('X-Frame-Options', 'SAMEORIGIN');
    }

    private function templateOrFail(string $key): array
    {
        $templates = self::catalogue();

        abort_unless(isset($templates[$key]), 404, 'Unknown email template.');

        return $templates[$key];
    }

    /**
     * Preview against a real booking when one is asked for (or exists),
     * otherwise fall back to representative sample data.
     */
    private function resolveOrder(mixed $orderId): Order
    {
        if (is_scalar($orderId) && $orderId !== '') {
            $order = Order::with(['items', 'customer'])->find($orderId);
            if ($order) {
                return $order;
            }
        }

        return $this->sampleOrder();
    }

    /**
     * An unsaved order that mirrors a typical booking, so the gallery works
     * on a fresh install and never depends on live data.
     */
    private function sampleOrder(): Order
    {
        $checkIn  = now()->addDays(6)->startOfDay();
        $checkOut = now()->addDays(9)->startOfDay();
        // Carbon 3 returns a float here, which would print as "3.0000000006"
        $nights   = (int) $checkIn->diffInDays($checkOut);

        $order = new Order([
            'order_number'      => 'ORD-SAMPLE01',
            'guest_name'        => 'Sample Guest',
            'guest_first_name'  => 'Sample',
            'guest_last_name'   => 'Guest',
            'guest_email'       => 'guest@example.com',
            'guest_phone'       => '+1 604 555 0142',
            'guest_address'     => '18 Spruce Trail',
            'guest_city'        => 'Hope',
            'guest_province'    => 'BC',
            'guest_postal_code' => 'V0X 1L0',
            'subtotal'          => 590.00,
            'tax_amount'        => 88.50,
            'loyalty_discount'  => 20.00,
            'pet_fee_total'     => 25.00,
            'laundry_fee_total' => 25.00,
            'grand_total'       => 658.50,
            'payment_status'    => 'paid',
            'booking_type'      => 'Personal',
        ]);

        $order->id = 0;
        $order->created_at = now();
        $order->updated_at = now();

        $item = new OrderItem([
            'listing_name'    => 'Cedar Lodge Suite',
            'check_in'        => $checkIn->toDateString(),
            'check_out'       => $checkOut->toDateString(),
            'rooms'           => 1,
            'pets'            => '1',
            'laundry'         => 'Yes (1 load)',
            'price_per_night' => 180.00,
            'nights'          => $nights,
            'item_total'      => 180.00 * $nights,
        ]);

        // Relations are set by hand because this order was never persisted.
        $order->setRelation('items', collect([$item]));
        $order->setRelation('customer', null);

        return $order;
    }

    private function subjectFor(string $mailable, Order $order): string
    {
        try {
            return (new $mailable($order))->envelope()->subject ?? '—';
        } catch (\Throwable) {
            return '—';
        }
    }
}
