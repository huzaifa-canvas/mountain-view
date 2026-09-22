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
                  @if(($order->pet_fee_total ?? 0) > 0)
                  <tr>
                    <td class="text-end">Pet Fee Total:</td>
                    <td class="text-end"><strong>{{ $currency }} {{ number_format($order->pet_fee_total, 2) }}</strong></td>
                  </tr>
                  @endif
                  @if(($order->laundry_fee_total ?? 0) > 0)
                  <tr>
                    <td class="text-end">Laundry Fee Total:</td>
                    <td class="text-end"><strong>{{ $currency }} {{ number_format($order->laundry_fee_total, 2) }}</strong></td>
                  </tr>
                  @endif
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
              <p><strong>Name:</strong> {{ $order->guest_first_name || $order->guest_last_name ? trim($order->guest_first_name . ' ' . $order->guest_last_name) : $order->guest_name }}</p>
              <p><strong>Email:</strong> {{ $order->guest_email }}</p>
              <p><strong>Phone:</strong> {{ $order->guest_phone ?? 'N/A' }}</p>
            @endif

            @if($order->guest_address || $order->guest_city || $order->guest_province || $order->guest_postal_code)
              <hr>
              <h6 class="fw-bold">Guest Address:</h6>
              <p class="mb-1">{{ $order->guest_address }}</p>
              <p class="mb-1">{{ implode(', ', array_filter([$order->guest_city, $order->guest_province, $order->guest_postal_code])) }}</p>
            @endif

            @if($order->guest_vehicle_number)
              <p class="mt-2"><strong>Vehicle #:</strong> <span class="badge bg-dark">{{ $order->guest_vehicle_number }}</span></p>
            @endif

            @if($order->guest_id_proof)
              <hr>
              <h6 class="fw-bold">Uploaded ID Proof:</h6>
              @php
                $ext = pathinfo($order->guest_id_proof, PATHINFO_EXTENSION);
              @endphp
              @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']))
                <div class="mb-2">
                  <a href="{{ asset($order->guest_id_proof) }}" target="_blank">
                    <img src="{{ asset($order->guest_id_proof) }}" class="img-fluid img-thumbnail" style="max-height:160px;" alt="ID Proof">
                  </a>
                </div>
              @endif
              <a href="{{ asset($order->guest_id_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                <i class="bi bi-file-earmark-text"></i> View Uploaded ID File
              </a>
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

            <hr>

            <h5 class="card-title">Checkout Status</h5>
            @if($order->checkout_status === 'checked_out')
              <p><span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i> Checked Out</span></p>
              <p class="text-muted small">Checked out at: {{ \Carbon\Carbon::parse($order->checked_out_at)->format('F d, Y g:i A') }}</p>
            @else
              <p><span class="badge bg-info text-dark fs-6"><i class="bi bi-house-door me-1"></i> Confirmed (In Stay)</span></p>
            @endif

            <hr>

            <h5 class="card-title">Actions</h5>
            <div class="d-grid gap-2">
              <!-- Send Reminder -->
              <form action="{{ route('admin.orders.send-reminder', $order->id) }}" method="POST" onsubmit="return confirm('Send booking reminder email to guest?');">
                @csrf
                <button type="submit" class="btn btn-outline-primary w-100 mb-2">
                  <i class="bi bi-envelope-paper me-1"></i> Send Reminder Email
                </button>
              </form>

              <!-- Mark as Checked Out -->
              @if($order->checkout_status !== 'checked_out')
              <form action="{{ route('admin.orders.mark-checked-out', $order->id) }}" method="POST" onsubmit="return confirm('Mark this booking as checked out? This will send a Thank You + Feedback email to the guest.');">
                @csrf
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-box-arrow-right me-1"></i> Mark as Checked Out
                </button>
              </form>
              @else
              <button class="btn btn-secondary w-100" disabled>
                <i class="bi bi-check-circle me-1"></i> Already Checked Out
              </button>
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>

    @if(session('success'))
    <div class="row">
      <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    </div>
    @endif

    @if(session('error'))
    <div class="row">
      <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    </div>
    @endif

  </section>

</main>

@include('admin.inc.footer')
