@include('admin.inc.header', ['pageTitle' => 'Bookings & Orders'])

@php
  $money = fn ($v) => $currency . ' ' . number_format($v, 2);
  $hasFilters = collect(request()->only(['search','status','listing_id','start_date','end_date','stay']))
                  ->filter(fn ($v) => $v !== null && $v !== '')
                  ->isNotEmpty();
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>Bookings &amp; Orders</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions">
      <a href="{{ route('admin.orders.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> New booking
      </a>
      <a href="{{ route('admin.orders.calendar') }}" class="btn btn-outline-secondary">
        <i class="bi bi-calendar-event me-1"></i> Calendar view
      </a>
      <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-primary">
        <i class="bi bi-chat-square-text me-1"></i> Guest feedback
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">

    <div class="mv-chips mb-3">
      <span class="mv-chip"><i class="bi bi-receipt"></i> {{ number_format($summary['count']) }} {{ $hasFilters ? 'matching' : 'total' }} {{ Str::plural('booking', $summary['count']) }}</span>
      <span class="mv-chip"><i class="bi bi-cash-coin"></i> {{ $money($summary['revenue']) }} collected</span>
      @if($hasFilters)
        <a href="{{ route('admin.orders.index') }}" class="mv-chip"><i class="bi bi-x-circle"></i> Clear filters</a>
      @endif
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="mv-filters">
      <div class="row g-3 align-items-end">

        <div class="col-xl-3 col-md-6">
          <label class="form-label" for="f-search">Search</label>
          <input type="search" id="f-search" name="search" class="form-control" placeholder="Order #, name or email…" value="{{ request('search') }}">
        </div>

        <div class="col-xl-2 col-md-6">
          <label class="form-label" for="f-status">Payment</label>
          <select id="f-status" name="status" class="form-select">
            <option value="">All payments</option>
            <option value="paid"    {{ request('status') == 'paid'    ? 'selected' : '' }}>Paid</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="failed"  {{ request('status') == 'failed'  ? 'selected' : '' }}>Failed</option>
          </select>
        </div>

        <div class="col-xl-2 col-md-6">
          <label class="form-label" for="f-stay">Stay</label>
          <select id="f-stay" name="stay" class="form-select">
            <option value="">All stays</option>
            <option value="arriving"    {{ request('stay') == 'arriving'    ? 'selected' : '' }}>Awaiting arrival</option>
            <option value="checked_in"  {{ request('stay') == 'checked_in'  ? 'selected' : '' }}>In house</option>
            <option value="no_show"     {{ request('stay') == 'no_show'     ? 'selected' : '' }}>No show</option>
            <option value="checked_out" {{ request('stay') == 'checked_out' ? 'selected' : '' }}>Checked out</option>
            <option value="cancelled"   {{ request('stay') == 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>

        <div class="col-xl-2 col-md-6">
          <label class="form-label" for="f-room">Room</label>
          <select id="f-room" name="listing_id" class="form-select">
            <option value="">All rooms</option>
            @foreach($listings as $listing)
              <option value="{{ $listing->listings_id }}" {{ request('listing_id') == $listing->listings_id ? 'selected' : '' }}>
                {{ $listing->listings_name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-xl-3 col-md-12">
          <label class="form-label">Check-in between</label>
          <div class="mv-date-range">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" aria-label="Check-in from">
            <input type="date" name="end_date"   class="form-control" value="{{ request('end_date') }}"   aria-label="Check-in to">
          </div>
        </div>

        <div class="col-12 d-flex flex-wrap gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Apply filters</button>
          <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</a>
        </div>

      </div>
    </form>

    <!-- Orders -->
    <div class="mv-table-wrap">
      <div class="table-responsive">
        <table class="table mv-responsive-table align-middle">
          <thead>
            <tr>
              <th>Order</th>
              <th>Guest</th>
              <th>Stay</th>
              <th>Total</th>
              <th>Payment</th>
              <th>Status</th>
              <th class="text-end">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
              @php
                $firstItem = $order->items->first();
                $isMember  = (bool) $order->customer_id;
                $guestName = $isMember
                    ? trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? ''))
                    : ($order->guest_name ?: 'Guest');
                $guestMail = $isMember ? ($order->customer->email ?? '') : $order->guest_email;
              @endphp
              <tr>
                <td data-label="Order">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="mv-cell-strong mv-nowrap">#{{ $order->order_number }}</a>
                  <div class="mv-cell-sub mv-nowrap">{{ $order->created_at->format('M d, Y · g:i A') }}</div>
                </td>

                <td data-label="Guest" class="mv-cell-block">
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="mv-cell-strong">{{ $guestName }}</span>
                    <span class="badge {{ $isMember ? 'bg-info' : 'bg-secondary' }}">{{ $isMember ? 'Member' : 'Guest' }}</span>
                  </div>
                  <div class="mv-cell-sub">{{ $guestMail }}</div>
                </td>

                <td data-label="Stay" class="mv-cell-block">
                  @if($firstItem)
                    <span class="mv-cell-strong mv-nowrap">
                      {{ \Carbon\Carbon::parse($firstItem->check_in)->format('M d') }}
                      &rarr;
                      {{ \Carbon\Carbon::parse($firstItem->check_out)->format('M d, Y') }}
                    </span>
                    <div class="mv-cell-sub">
                      {{ $order->roomCount() }} {{ Str::plural('room', $order->roomCount()) }} &middot;
                      {{ $firstItem->nights }} {{ Str::plural('night', $firstItem->nights) }} &middot;
                      {{ $order->booking_type ?? 'Personal' }}
                    </div>
                  @else
                    <span class="text-muted">&mdash;</span>
                  @endif
                </td>

                <td data-label="Total"><span class="mv-cell-strong">{{ $money($order->grand_total) }}</span></td>

                <td data-label="Payment">
                  @if($order->payment_status == 'paid')
                    <span class="badge bg-success">Paid</span>
                  @elseif($order->payment_status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                  @else
                    <span class="badge bg-danger">{{ ucfirst($order->payment_status) }}</span>
                  @endif
                </td>

                <td data-label="Status">
                  @php
                    $tone = [
                        'checked_out' => 'bg-secondary',
                        'checked_in'  => 'bg-info',
                        'cancelled'   => 'bg-danger',
                        'no_show'     => 'bg-danger',
                        'awaiting'    => 'bg-warning',
                    ][$order->stayState()];
                  @endphp
                  <span class="badge {{ $tone }}">{{ $order->stayLabel() }}</span>
                </td>

                <td data-label="" class="text-end">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                    Details <i class="bi bi-chevron-right ms-1"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7">
                  <div class="mv-empty">
                    <i class="bi bi-inbox"></i>
                    {{ $hasFilters ? 'No bookings match these filters.' : 'No bookings have been made yet.' }}
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($orders->hasPages())
      <div class="d-flex justify-content-center mt-4">
        {{ $orders->appends(request()->query())->links() }}
      </div>
    @endif

  </section>

</main>

@include('admin.inc.footer')
