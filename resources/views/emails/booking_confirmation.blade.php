<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #eee; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f9f9f9; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mountain View Booking Confirmation</h2>
            <p>Order #{{ $order->order_number }}</p>
        </div>
        
        <p>Dear {{ $order->customer_id ? $order->customer->first_name : $order->guest_name }},</p>
        
        <p>Thank you for your booking! Your payment has been successfully processed.</p>
        
        <h3>Booking Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Nights</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->listing_name }} ({{ $item->rooms }} Room(s))</td>
                    <td>{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</td>
                    <td>{{ $item->nights }}</td>
                    <td>${{ number_format($item->item_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <table style="border:none; width:50%; margin-left:auto;">
            <tr style="border:none;">
                <td style="border:none; text-align:right;">Subtotal:</td>
                <td style="border:none; text-align:right;">${{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr style="border:none;">
                <td style="border:none; text-align:right;">Taxes & Fees:</td>
                <td style="border:none; text-align:right;">${{ number_format($order->tax_amount, 2) }}</td>
            </tr>
            @if($order->loyalty_discount > 0)
            <tr style="border:none;">
                <td style="border:none; text-align:right;">Loyalty Discount:</td>
                <td style="border:none; text-align:right;">-${{ number_format($order->loyalty_discount, 2) }}</td>
            </tr>
            @endif
            <tr style="border:none;" class="total-row">
                <td style="border:none; text-align:right;">Grand Total:</td>
                <td style="border:none; text-align:right;">${{ number_format($order->grand_total, 2) }}</td>
            </tr>
        </table>
        
        <div class="footer">
            <p>If you have any questions about your booking, please contact us.</p>
            <p>&copy; {{ date('Y') }} Mountain View. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
