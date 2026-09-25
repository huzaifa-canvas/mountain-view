<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Your Stay</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; color: #1e293b; line-height: 1.6; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #184E77, #1e6091); color: #ffffff; padding: 32px 24px; text-align: center; }
        .header h2 { margin: 0; font-size: 22px; font-weight: 800; }
        .header p { margin: 6px 0 0; font-size: 14px; opacity: 0.9; }
        .content { padding: 28px 24px; }
        .greeting { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 12px; }
        .feedback-box { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 1px solid #bae6fd; border-radius: 12px; padding: 24px; margin: 24px 0; text-align: center; }
        .feedback-box h3 { margin: 0 0 8px; font-size: 17px; color: #0369a1; font-weight: 800; }
        .feedback-box p { margin: 0 0 16px; font-size: 13px; color: #475569; line-height: 1.5; }
        .btn-feedback { display: inline-block; background: #184E77; color: #ffffff !important; padding: 12px 28px; border-radius: 25px; text-decoration: none; font-weight: 700; font-size: 14px; letter-spacing: 0.3px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
        th { background: #f1f5f9; color: #334155; text-align: left; padding: 10px; border-bottom: 2px solid #e2e8f0; font-weight: 700; }
        td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .promo-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 16px; margin: 20px 0; text-align: center; }
        .promo-box p { margin: 0 0 12px; font-size: 13px; color: #0369a1; line-height: 1.5; }
        .btn-link { display: inline-block; background: #184E77; color: #ffffff !important; padding: 10px 22px; border-radius: 20px; text-decoration: none; font-weight: 700; font-size: 13px; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🏔️ Mountain View Motel</h2>
            <p>Thank You for Staying With Us!</p>
        </div>
        
        <div class="content">
            @php
                $customerName = $order->customer_id ? ($order->customer->first_name . ' ' . $order->customer->last_name) : ($order->guest_first_name ? trim($order->guest_first_name . ' ' . $order->guest_last_name) : $order->guest_name);
            @endphp

            <p class="greeting">Dear {{ $customerName ?: 'Valued Guest' }},</p>
            
            <p>Thank you for choosing <strong>Mountain View Motel</strong> for your recent stay. We truly hope you had a wonderful and comfortable experience with us in Hope, BC.</p>
            
            <p>Your booking <strong>#{{ $order->order_number }}</strong> has been checked out successfully.</p>

            <h3 style="font-size:15px; color:#0f172a; margin-top:24px; border-bottom:2px solid #f1f5f9; padding-bottom:8px;">Stay Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Nights</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->listing_name }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</td>
                        <td>{{ $item->nights }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Feedback CTA -->
            <div class="feedback-box">
                <h3>We'd Love Your Feedback!</h3>
                <p>Your opinion matters to us. Please take a moment to share your experience so we can continue to improve our services.</p>
                <a href="{{ url('feedback/' . $order->order_number) }}" class="btn-feedback">Share Your Feedback &rarr;</a>
            </div>

            <p style="font-size:13px; color:#64748b; margin-top:20px;">If you have any concerns or need further assistance, please don't hesitate to reach out to us directly.</p>

            @if(!$order->customer_id)
                <div class="promo-box">
                    <p>
                        Please come back soon &mdash; and do remember to sign up for our Membership Program
                        so you earn reward points on every stay with us and can use those points for great
                        discounts in future.
                    </p>
                    <a href="{{ url('customer/register') }}" class="btn-link">Sign Up For Membership Program &rarr;</a>
                </div>
            @else
                <p style="font-size:13px; color:#475569; margin-top:14px;">
                    Your reward points from this stay have been added to your account. Use them for a discount
                    the next time you book with us.
                </p>
            @endif

            @include('emails.partials.signoff', ['closing' => 'Looking forward to welcoming you again soon!'])
        </div>
        
        <div class="footer">
            <p>Mountain View Motel, Hope (BC), Canada</p>
            <p>&copy; {{ date('Y') }} Mountain View Motel. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
