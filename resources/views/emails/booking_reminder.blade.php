<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Reminder</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; color: #1e293b; line-height: 1.6; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { background: #184E77; color: #ffffff; padding: 28px 24px; text-align: center; }
        .header h2 { margin: 0; font-size: 22px; font-weight: 800; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.9; }
        .content { padding: 28px 24px; }
        .greeting { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 12px; }
        
        .rules-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin: 24px 0; }
        .rules-title { font-size: 16px; font-weight: 800; color: #0f172a; border-bottom: 2px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 16px; }
        .rule-row { display: flex; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .rule-label { width: 140px; font-weight: 700; color: #334155; flex-shrink: 0; }
        .rule-val { color: #475569; }
        
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
        th { background: #f1f5f9; color: #334155; text-align: left; padding: 10px; border-bottom: 2px solid #e2e8f0; font-weight: 700; }
        td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mountain View Motel</h2>
            <p>Upcoming Stay Gentle Reminder - Order #{{ $order->order_number }}</p>
        </div>
        
        <div class="content">
            @php
                $customerName = $order->customer_id ? ($order->customer->first_name . ' ' . $order->customer->last_name) : ($order->guest_first_name ? trim($order->guest_first_name . ' ' . $order->guest_last_name) : $order->guest_name);
                $firstItem = $order->items->first();
                $checkInDate = $firstItem ? \Carbon\Carbon::parse($firstItem->check_in) : null;
            @endphp

            <p class="greeting">Dear {{ $customerName ?: 'Valued Guest' }},</p>
            
            <p>This is a gentle reminder that your booking for <strong>{{ $firstItem ? $firstItem->listing_name : 'Room' }}</strong> on <strong>{{ $checkInDate ? $checkInDate->format('F d, Y (l)') : 'your scheduled date' }}</strong> is confirmed at <strong>Mountain View Motel (MWM)</strong> in Hope (BC).</p>
            
            <h3 style="font-size:15px; color:#0f172a; margin-top:24px; border-bottom:2px solid #f1f5f9; padding-bottom:8px;">Booking Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Room / Service</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Nights</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->listing_name }}</strong> ({{ $item->rooms }} Room(s))</td>
                        <td>{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</td>
                        <td>{{ $item->nights }} Night(s)</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Housing Rules & Policies Card -->
            <div class="rules-card">
                <div class="rules-title">Housing Rules / Policies:</div>
                
                <table style="margin:0; border:none;">
                    <tr>
                        <td style="width:30%; font-weight:700; color:#184E77; border:none; padding:6px 0;">Check-in:</td>
                        <td style="border:none; padding:6px 0;">From 3:00 PM to 12:00 AM</td>
                    </tr>
                    <tr>
                        <td style="font-weight:700; color:#184E77; border:none; padding:6px 0;">Check-out:</td>
                        <td style="border:none; padding:6px 0;">From 11:00 AM to 11:30 AM</td>
                    </tr>
                    <tr>
                        <td style="font-weight:700; color:#184E77; border:none; padding:6px 0;">Cancellation / Prepayment:</td>
                        <td style="border:none; padding:6px 0;">Cancellation and prepayment policies vary according to accommodation type.</td>
                    </tr>
                    <tr>
                        <td style="font-weight:700; color:#184E77; border:none; padding:6px 0;">Children & Beds:</td>
                        <td style="border:none; padding:6px 0;">Children of all ages are welcome. Cribs and extra beds are not available.</td>
                    </tr>
                    <tr>
                        <td style="font-weight:700; color:#184E77; border:none; padding:6px 0;">Age restriction:</td>
                        <td style="border:none; padding:6px 0;">The minimum age for check-in is 18.</td>
                    </tr>
                    <tr>
                        <td style="font-weight:700; color:#184E77; border:none; padding:6px 0;">Pets:</td>
                        <td style="border:none; padding:6px 0;">Pets are allowed. Charges may apply.</td>
                    </tr>
                    <tr>
                        <td style="font-weight:700; color:#184E77; border:none; padding:6px 0;">Cards accepted:</td>
                        <td style="border:none; padding:6px 0;">Visa, MasterCard, Discover, Debit Card (Cash is not accepted).</td>
                    </tr>
                </table>
            </div>

            @include('emails.partials.signoff')
        </div>
        
        <div class="footer">
            <p>Mountain View Motel, Hope (BC), Canada</p>
            <p>&copy; {{ date('Y') }} Mountain View Motel. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
