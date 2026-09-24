@include('admin.inc.header', ['pageTitle' => 'Dashboard'])

@php
  $hour = now()->hour;
  $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
  $money = fn ($v) => $currency . ' ' . number_format($v, 2);
@endphp

<main id="main" class="main">

  <!-- Greeting -->
  <section class="mv-hero">
    <p class="mv-hero-greeting">{{ $greeting }}</p>
    <h1 class="mv-hero-name">{{ Auth::user()->name ?? 'Admin' }}</h1>

    <div class="mv-chips">
      <span class="mv-chip"><i class="bi bi-calendar3"></i> {{ now()->format('l, F j, Y') }}</span>
      <span class="mv-chip"><i class="bi bi-house-door"></i> {{ $stats['in_stay'] }} guests in stay</span>
      <span class="mv-chip"><i class="bi bi-cart-check"></i> {{ $stats['orders_today'] }} bookings today</span>
      <span class="mv-chip"><i class="bi bi-door-open"></i> {{ $stats['listings_active'] }} of {{ $stats['listings_total'] }} rooms active</span>
    </div>
  </section>

  <!-- Key numbers -->
  <section class="mb-2">
    <div class="row g-3">

      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.orders.index') }}" class="mv-stat">
          <span class="mv-stat-icon"><i class="bi bi-cart-check"></i></span>
          <div>
            <div class="mv-stat-label">Total bookings</div>
            <div class="mv-stat-value">{{ number_format($stats['orders_total']) }}</div>
            <div class="mv-stat-meta">{{ number_format($stats['orders_paid']) }} paid &middot; {{ $stats['orders_today'] }} today</div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="mv-stat">
          <span class="mv-stat-icon is-green"><i class="bi bi-cash-coin"></i></span>
          <div>
            <div class="mv-stat-label">Revenue collected</div>
            <div class="mv-stat-value">{{ $money($stats['revenue_total']) }}</div>
            <div class="mv-stat-meta">{{ $money($stats['revenue_month']) }} this month</div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6">
        <a href="{{ url('admin/listings') }}" class="mv-stat">
          <span class="mv-stat-icon is-gold"><i class="bi bi-door-open"></i></span>
          <div>
            <div class="mv-stat-label">Rooms &amp; listings</div>
            <div class="mv-stat-value">{{ number_format($stats['listings_total']) }}</div>
            <div class="mv-stat-meta">{{ $stats['listings_active'] }} active &middot; {{ $stats['listings_total'] - $stats['listings_active'] }} inactive</div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.feedbacks.index') }}" class="mv-stat">
          <span class="mv-stat-icon is-blue"><i class="bi bi-people"></i></span>
          <div>
            <div class="mv-stat-label">Members &amp; feedback</div>
            <div class="mv-stat-value">{{ number_format($stats['customers']) }}</div>
            <div class="mv-stat-meta">{{ number_format($stats['feedbacks']) }} feedback entries</div>
          </div>
        </a>
      </div>

    </div>
  </section>

  <!-- Recent bookings -->
  <section class="mt-4">
    <div class="mv-section-head">
      <h2>Recent bookings</h2>
      <a href="{{ route('admin.orders.index') }}">See all</a>
    </div>

    <div class="mv-table-wrap">
      <div class="table-responsive">
        <table class="table mv-responsive-table align-middle">
          <thead>
            <tr>
              <th>Order</th>
              <th>Guest</th>
              <th>Stay</th>
              <th>Total</th>
              <th>Status</th>
              <th class="text-end">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recent_orders as $order)
              @php
                $firstItem = $order->items->first();
                $guest = $order->customer_id
                    ? trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? ''))
                    : ($order->guest_name ?: 'Guest');
              @endphp
              <tr>
                <td data-label="Order">
                  <span class="mv-cell-strong">#{{ $order->order_number }}</span>
                  <div class="mv-cell-sub">{{ $order->created_at->format('M d, Y') }}</div>
                </td>
                <td data-label="Guest">
                  <span class="mv-cell-strong">{{ $guest }}</span>
                  <div class="mv-cell-sub">{{ $order->customer_id ? ($order->customer->email ?? '') : $order->guest_email }}</div>
                </td>
                <td data-label="Stay">
                  @if($firstItem)
                    {{ \Carbon\Carbon::parse($firstItem->check_in)->format('M d') }}
                    &rarr;
                    {{ \Carbon\Carbon::parse($firstItem->check_out)->format('M d') }}
                    <div class="mv-cell-sub">{{ $order->roomCount() }} {{ Str::plural('room', $order->roomCount()) }}</div>
                  @else
                    <span class="text-muted">&mdash;</span>
                  @endif
                </td>
                <td data-label="Total"><span class="mv-cell-strong">{{ $money($order->grand_total) }}</span></td>
                <td data-label="Status">
                  @if($order->payment_status == 'paid')
                    <span class="badge bg-success">Paid</span>
                  @elseif($order->payment_status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                  @else
                    <span class="badge bg-danger">{{ ucfirst($order->payment_status) }}</span>
                  @endif
                </td>
                <td data-label="" class="text-end">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="mv-empty">
                    <i class="bi bi-inbox"></i>
                    No bookings yet. They will appear here as guests check out.
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Upcoming arrivals + latest feedback -->
  <section class="mt-4">
    <div class="row g-4">

      <div class="col-lg-7">
        <div class="mv-section-head">
          <h2>Upcoming arrivals</h2>
          <a href="{{ route('admin.orders.calendar') }}">Calendar</a>
        </div>

        <div class="card">
          <div class="card-body">
            @forelse($upcoming as $item)
              @php
                $guest = $item->order->customer_id
                    ? trim(($item->order->customer->first_name ?? '') . ' ' . ($item->order->customer->last_name ?? ''))
                    : ($item->order->guest_name ?: 'Guest');
                $checkIn = \Carbon\Carbon::parse($item->check_in);
                $daysAway = now()->startOfDay()->diffInDays($checkIn, false);
              @endphp
              <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--mv-border) !important;">
                <span class="mv-stat-icon is-gold" style="width:38px;height:38px;font-size:1rem;">
                  <i class="bi bi-box-arrow-in-right"></i>
                </span>
                <div class="flex-grow-1 min-w-0">
                  <div class="mv-cell-strong text-truncate">{{ $guest }}</div>
                  <div class="mv-cell-sub text-truncate">{{ $item->listing_name }} &middot; {{ $item->rooms }} {{ Str::plural('room', $item->rooms) }} &middot; {{ $item->nights }} {{ Str::plural('night', $item->nights) }}</div>
                </div>
                <div class="text-end flex-shrink-0">
                  <div class="mv-cell-strong">{{ $checkIn->format('M d') }}</div>
                  <div class="mv-cell-sub">
                    @if($daysAway == 0) Today
                    @elseif($daysAway == 1) Tomorrow
                    @else in {{ $daysAway }} days
                    @endif
                  </div>
                </div>
                <a href="{{ route('admin.orders.show', $item->order_id) }}" class="btn btn-sm btn-outline-secondary mv-btn-icon flex-shrink-0" title="Open booking">
                  <i class="bi bi-chevron-right"></i>
                </a>
              </div>
            @empty
              <div class="mv-empty">
                <i class="bi bi-calendar-x"></i>
                No arrivals scheduled in the next two weeks.
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="mv-section-head">
          <h2>Latest feedback</h2>
          <a href="{{ route('admin.feedbacks.index') }}">See all</a>
        </div>

        <div class="card">
          <div class="card-body">
            @forelse($latest_feedbacks as $feedback)
              <div class="py-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--mv-border) !important;">
                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                  <span class="mv-cell-strong">{{ $feedback->guest_name ?: 'Guest' }}</span>
                  <span class="badge bg-secondary">{{ $feedback->category ?: 'General' }}</span>
                </div>
                <p class="mb-1" style="font-size:.88rem;color:var(--mv-text-2);">{{ Str::limit($feedback->message, 110) }}</p>
                <div class="mv-cell-sub">{{ $feedback->created_at?->format('M d, Y') }}</div>
              </div>
            @empty
              <div class="mv-empty">
                <i class="bi bi-chat-square-text"></i>
                No guest feedback received yet.
              </div>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </section>

</main><!-- End #main -->

@include('admin.inc.footer')
