@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Bookings & Orders</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>
      </nav>
    </div>
    <div>
      <a href="{{ route('admin.orders.calendar') }}" class="btn btn-primary"><i class="bi bi-calendar-event me-1"></i> Calendar View</a>
    </div>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Order List</h5>

            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-4 align-items-end">
              <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Search Text</label>
                <input type="text" name="search" class="form-control" placeholder="Order #, Customer..." value="{{ request('search') }}">
              </div>
              <div class="col-md-2 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Status</label>
                <select name="status" class="form-select">
                  <option value="">All Statuses</option>
                  <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                  <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
              </div>
              <div class="col-md-2 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Room Type</label>
                <select name="listing_id" class="form-select">
                  <option value="">All Rooms</option>
                  @foreach($listings as $listing)
                    <option value="{{ $listing->listings_id }}" {{ request('listing_id') == $listing->listings_id ? 'selected' : '' }}>{{ $listing->listings_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Check-in From</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
              </div>
              <div class="col-md-2 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Check-in To</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
              </div>
              <div class="col-md-1 col-sm-6 d-flex gap-1">
                <button type="submit" class="btn btn-secondary w-100" title="Filter"><i class="bi bi-filter"></i></button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100" title="Clear Filters"><i class="bi bi-arrow-counterclockwise"></i></a>
              </div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead>
                  <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($orders as $order)
                  <tr>
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td>
                      @if($order->customer_id)
                        <span class="badge bg-info text-dark">Registered</span> {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
                        <small class="text-muted">{{ $order->customer->email }}</small>
                      @else
                        <span class="badge bg-secondary">Guest</span> {{ $order->guest_name }}<br>
                        <small class="text-muted">{{ $order->guest_email }}</small>
                      @endif
                    </td>
                    <td>{{ $order->booking_type ?? 'Personal' }}</td>
                    <td><strong>{{ $currency }} {{ number_format($order->grand_total, 2) }}</strong></td>
                    <td>
                      @if($order->payment_status == 'paid')
                        <span class="badge bg-success">Paid</span>
                      @elseif($order->payment_status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                      @else
                        <span class="badge bg-danger">{{ ucfirst($order->payment_status) }}</span>
                      @endif
                    </td>
                    <td>{{ $order->created_at->format('M d, Y g:i A') }}</td>
                    <td>
                      <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i> View Details</a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No orders found.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
              {{ $orders->appends(request()->query())->links() }}
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>

@include('admin.inc.footer')
