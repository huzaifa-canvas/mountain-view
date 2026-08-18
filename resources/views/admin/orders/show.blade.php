@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Order Details - #{{ $order->order_number }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </nav>
    </div>
    <div>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Orders</a>
    </div>
  </div>

  <section class="section">
    <div class="row">
      <!-- Order Summary Card -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Booked Items</h5>

            <div class="table-responsive">
              <table class="table table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Listing / Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Nights</th>
                    <th>Rooms</th>
                    <th>Price/Night</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($order->items as $item)
                  <tr>
                    <td>
                      <strong>{{ $item->listing_name }}</strong><br>
                      <small class="text-muted">Pets: {{ $item->pets }} | Laundry: {{ $item->laundry }}</small>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</td>
                    <td>{{ $item->nights }}</td>
                    <td>{{ $item->rooms }}</td>
                    <td>{{ $currency }} {{ number_format($item->price_per_night, 2) }}</td>
                    <td><strong>{{ $currency }} {{ number_format($item->item_total, 2) }}</strong></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="row mt-4">
              <div class="col-md-6 offset-md-6">
                <table class="table table-borderless">
                  <tr>
                    <td class="text-end">Subtotal:</td>
                    <td class="text-end"><strong>{{ $currency }} {{ number_format($order->subtotal, 2) }}</strong></td>
                  </tr>
                  <tr>
                    <td class="text-end">Tax Amount:</td>
                    <td class="text-end"><strong>{{ $currency }} {{ number_format($order->tax_amount, 2) }}</strong></td>
                  </tr>
                  @if($order->loyalty_discount > 0)
                  <tr class="text-success">
                    <td class="text-end">Loyalty Discount:</td>
                    <td class="text-end"><strong>-{{ $currency }} {{ number_format($order->loyalty_discount, 2) }}</strong></td>
                  </tr>
                  @endif
                  <tr class="border-top fs-5 fw-bold">
                    <td class="text-end">Grand Total:</td>
                    <td class="text-end text-primary">{{ $currency }} {{ number_format($order->grand_total, 2) }}</td>
                  </tr>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Customer & Payment Info Card -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Customer Information</h5>
            
            @if($order->customer_id)
              <p><strong>Type:</strong> <span class="badge bg-info text-dark">Registered Member</span></p>
              <p><strong>Name:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
              <p><strong>Email:</strong> {{ $order->customer->email }}</p>
              <p><strong>Phone:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
              <p><strong>Points Balance:</strong> {{ number_format($order->customer->loyalty_points, 0) }} pts</p>
            @else
              <p><strong>Type:</strong> <span class="badge bg-secondary">Guest</span></p>
              <p><strong>Name:</strong> {{ $order->guest_name }}</p>
              <p><strong>Email:</strong> {{ $order->guest_email }}</p>
              <p><strong>Phone:</strong> {{ $order->guest_phone ?? 'N/A' }}</p>
            @endif

            <hr>

            <h5 class="card-title">Payment Information</h5>
            <p><strong>Booking Type:</strong> {{ $order->booking_type }}</p>
            <p><strong>Status:</strong> 
              @if($order->payment_status == 'paid')
                <span class="badge bg-success">Paid</span>
              @else
                <span class="badge bg-warning text-dark">{{ ucfirst($order->payment_status) }}</span>
              @endif
            </p>
            <p><strong>Stripe PaymentIntent ID:</strong><br><small class="text-muted text-break">{{ $order->stripe_payment_intent_id ?? 'N/A' }}</small></p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y g:i A') }}</p>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>

@include('admin.inc.footer')
