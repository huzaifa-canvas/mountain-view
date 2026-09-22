<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; color: #1e293b; line-height: 1.6; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { background: #184E77; color: #ffffff; padding: 28px 24px; text-align: center; }
        .header h2 { margin: 0; font-size: 22px; font-weight: 800; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.9; }
        .content { padding: 28px 24px; }
        .greeting { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 12px; }
        .promo-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 16px; margin: 20px 0; text-align: center; }
        .promo-box p { margin: 0 0 12px; font-size: 13px; color: #0369a1; line-height: 1.5; }
        .btn-link { display: inline-block; background: #184E77; color: #ffffff !important; padding: 10px 22px; border-radius: 20px; text-decoration: none; font-weight: 700; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
        th { background: #f1f5f9; color: #334155; text-align: left; padding: 10px; border-bottom: 2px solid #e2e8f0; font-weight: 700; }
        td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .totals-table td { border: none; padding: 4px 10px; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mountain View Motel</h2>
            <p>Booking Confirmation - Order #{{ $order->order_number }}</p>
        </div>
        
        <div class="content">
            @php
                $customerName = $order->customer_id ? ($order->customer->first_name . ' ' . $order->customer->last_name) : ($order->guest_first_name ? trim($order->guest_first_name . ' ' . $order->guest_last_name) : $order->guest_name);
            @endphp

            <p class="greeting">Dear {{ $customerName ?: 'Valued Guest' }},</p>
            
            <p>Thank you for choosing <strong>Mountain View Motel (MWM)</strong> in Hope (BC) for your stay. Your booking is confirmed and we look forward to welcoming you at MWM.</p>
            
            <div class="promo-box">
                <p>In case, you haven't signed up for our Membership Program using the link below so that you can start earning reward points for every stay and can use these points to avail great discounts in future.</p>
                <a href="{{ url('customer/register') }}" class="btn-link">Sign Up For Membership Program &rarr;</a>
            </div>

            <h3 style="font-size:15px; color:#0f172a; margin-top:24px; border-bottom:2px solid #f1f5f9; padding-bottom:8px;">Booking Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Room / Service</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Nights</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->listing_name }}</strong> ({{ $item->rooms }} Room(s))</td>
                        <td>{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</td>
                        <td>{{ $item->nights }}</td>
                        <td><strong>${{ number_format($item->item_total, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <table class="totals-table" style="width:60%; margin-left:auto;">
                <tr>
                    <td style="text-align:right;">Subtotal:</td>
                    <td style="text-align:right;"><strong>${{ number_format($order->subtotal, 2) }}</strong></td>
                </tr>
                <tr>
                    <td style="text-align:right;">Taxes & Fees:</td>
                    <td style="text-align:right;"><strong>${{ number_format($order->tax_amount, 2) }}</strong></td>
                </tr>
                @if($order->loyalty_discount > 0)
                <tr style="color:#059669;">
                    <td style="text-align:right;">Loyalty Discount:</td>
                    <td style="text-align:right;"><strong>-${{ number_format($order->loyalty_discount, 2) }}</strong></td>
                </tr>
                @endif
                <tr style="font-size:15px; font-weight:bold; color:#184E77;">
                    <td style="text-align:right; border-top:1.5px solid #cbd5e1; padding-top:8px;">Grand Total:</td>
                    <td style="text-align:right; border-top:1.5px solid #cbd5e1; padding-top:8px;">${{ number_format($order->grand_total, 2) }}</td>
                </tr>
            </table>

            <p style="margin-top:30px; font-weight:600; color:#334155;">
                Looking forward to welcoming you again soon!<br>
                <span style="color:#184E77; font-weight:700;">Mountain View Motel Management</span>
            </p>
        </div>
        
        <div class="footer">
            <p>Mountain View Motel, Hope (BC), Canada</p>
            <p>&copy; {{ date('Y') }} Mountain View Motel. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
