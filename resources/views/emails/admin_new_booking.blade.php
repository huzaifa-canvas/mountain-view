<!DOCTYPE html>
<html>
<head>
    <title>New Booking Alert</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #eee; padding: 20px; }
        .header { background-color: #000; color: #fff; padding: 15px; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Booking Alert</h2>
        </div>
        
        <p>A new booking has been received and paid successfully.</p>
        
        <h3>Order Information</h3>
        <table>
            <tr>
                <th>Order Number</th>
                <td>{{ $order->order_number }}</td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>{{ $order->customer_id ? $order->customer->first_name . ' ' . $order->customer->last_name : $order->guest_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $order->customer_id ? $order->customer->email : $order->guest_email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $order->customer_id ? $order->customer->phone : $order->guest_phone }}</td>
            </tr>
            <tr>
                <th>Booking Type</th>
                <td>{{ $order->booking_type }}</td>
            </tr>
            <tr>
                <th>Total Paid</th>
                <td>${{ number_format($order->grand_total, 2) }}</td>
            </tr>
        </table>
        
        <h3>Rooms Booked</h3>
        <table>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Dates</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->listing_name }}</td>
                    <td>
                        Check-in: {{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}<br>
                        Check-out: {{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}
                    </td>
                    <td>{{ $item->rooms }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <p>Login to the admin dashboard for more details.</p>
    </div>
</body>
</html>
