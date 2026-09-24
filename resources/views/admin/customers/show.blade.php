@include('admin.inc.header', ['pageTitle' => trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: 'Member'])

@php
  $money = fn ($v) => $currency . ' ' . number_format((float) $v, 2);

  $fullName = trim(implode(' ', array_filter([$customer->first_name, $customer->middle_name, $customer->last_name])))
      ?: 'Unnamed member';
  $initials = collect([$customer->first_name, $customer->last_name])
      ->filter()->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->implode('');

  $addressLine = implode(', ', array_filter([$customer->city, $customer->state, $customer->zip_code]));
  $fullAddress = trim(implode(', ', array_filter([$customer->address, $addressLine])));

  $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>{{ $fullName }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.members.index') }}">Members</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions mv-no-print">
      <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> All members
      </a>
      <a href="mailto:{{ $customer->email }}" class="btn btn-primary">
        <i class="bi bi-envelope me-1"></i> Email member
      </a>
    </div>
  </div>

  <section class="section">

    <!-- Summary strip -->
    <div class="row g-3 mb-1">
      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon is-gold"><i class="bi bi-star"></i></span>
          <div>
            <div class="mv-stat-label">Loyalty points</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">{{ number_format($customer->loyalty_points) }}</div>
            <div class="mv-stat-meta">{{ number_format($stats['earned']) }} earned &middot; {{ number_format($stats['redeemed']) }} redeemed</div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon"><i class="bi bi-cart-check"></i></span>
          <div>
            <div class="mv-stat-label">Bookings</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">{{ $stats['bookings'] }}</div>
            <div class="mv-stat-meta">{{ $stats['paid'] }} paid &middot; {{ $stats['nights'] }} {{ Str::plural('night', $stats['nights']) }}</div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon is-green"><i class="bi bi-cash-coin"></i></span>
          <div>
            <div class="mv-stat-label">Total spent</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">{{ $money($stats['spent']) }}</div>
            <div class="mv-stat-meta">across paid bookings</div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon is-blue"><i class="bi bi-calendar-check"></i></span>
          <div>
            <div class="mv-stat-label">Last stay</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">
              {{ $stats['last_stay'] ? \Carbon\Carbon::parse($stats['last_stay'])->format('M d, Y') : '—' }}
            </div>
            <div class="mv-stat-meta">member since {{ $customer->created_at?->format('M Y') ?? '—' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mt-1">

      <!-- Left column -->
      <div class="col-xl-8">

        <!-- Bookings -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bookings</h5>

            <div class="mv-table-wrap">
              <div class="table-responsive">
                <table class="table mv-responsive-table align-middle">
                  <thead>
                    <tr>
                      <th>Order</th>
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
                        $tone = [
                            'checked_out' => 'bg-secondary',
                            'checked_in'  => 'bg-info',
                            'cancelled'   => 'bg-danger',
                            'no_show'     => 'bg-danger',
                            'awaiting'    => 'bg-warning',
                        ][$order->stayState()];
                      @endphp
                      <tr>
                        <td data-label="Order">
                          <a href="{{ route('admin.orders.show', $order->id) }}" class="mv-cell-strong mv-nowrap">#{{ $order->order_number }}</a>
                          <div class="mv-cell-sub mv-nowrap">{{ $order->created_at->format('M d, Y') }}</div>
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
                              {{ $firstItem->nights }} {{ Str::plural('night', $firstItem->nights) }}
                            </div>
                          @else
                            <span class="text-muted">&mdash;</span>
                          @endif
                        </td>
                        <td data-label="Total" class="mv-nowrap"><span class="mv-cell-strong">{{ $money($order->grand_total) }}</span></td>
                        <td data-label="Payment">
                          @if($order->payment_status === 'paid')
                            <span class="badge bg-success">Paid</span>
                          @elseif($order->payment_status === 'pending')
                            <span class="badge bg-warning">Pending</span>
                          @else
                            <span class="badge bg-danger">{{ ucfirst($order->payment_status) }}</span>
                          @endif
                        </td>
                        <td data-label="Status"><span class="badge {{ $tone }}">{{ $order->stayLabel() }}</span></td>
                        <td data-label="" class="text-end">
                          <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Open</a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6">
                          <div class="mv-empty">
                            <i class="bi bi-inbox"></i>
                            This member has not booked a stay yet.
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- ID proofs -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Uploaded ID proof</h5>

            @if($idProofs->isEmpty())
              <div class="mv-empty">
                <i class="bi bi-file-earmark-person"></i>
                No ID document has been uploaded on any of this member's bookings.
              </div>
            @else
              <p class="mv-cell-sub mb-3">
                ID is uploaded per booking at checkout, so a member can have more than one on file.
              </p>
              <div class="row g-3">
                @foreach($idProofs as $order)
                  @php $ext = strtolower(pathinfo($order->guest_id_proof, PATHINFO_EXTENSION)); @endphp
                  <div class="col-md-6">
                    <div class="mv-idcard">
                      @if(in_array($ext, $imageTypes, true))
                        <a href="{{ asset($order->guest_id_proof) }}" target="_blank" rel="noopener">
                          {{-- If the file has gone missing from disk, fall back to the
                               placeholder rather than a broken image with sprawling alt text. --}}
                          <img src="{{ asset($order->guest_id_proof) }}" alt="ID proof"
                               onerror="this.closest('a').outerHTML='&lt;div class='mv-idcard-file'&gt;&lt;i class='bi bi-file-earmark-x'&gt;&lt;/i&gt; File missing&lt;/div&gt;'">
                        </a>
                      @else
                        <div class="mv-idcard-file"><i class="bi bi-file-earmark-text"></i> {{ strtoupper($ext ?: 'file') }}</div>
                      @endif

                      <div class="mv-idcard-foot">
                        <div class="min-w-0">
                          <a href="{{ route('admin.orders.show', $order->id) }}" class="mv-cell-strong">#{{ $order->order_number }}</a>
                          <div class="mv-cell-sub">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <a href="{{ asset($order->guest_id_proof) }}" target="_blank" rel="noopener"
                           class="btn btn-sm btn-outline-secondary mv-nowrap">
                          <i class="bi bi-box-arrow-up-right me-1"></i> Open
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>

        <!-- Loyalty ledger -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Loyalty history</h5>

            @if($transactions->isEmpty())
              <div class="mv-empty">
                <i class="bi bi-star"></i>
                No points have been earned or redeemed yet.
              </div>
            @else
              <div class="mv-table-wrap">
                <div class="table-responsive">
                  <table class="table mv-responsive-table align-middle">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Points</th>
                        <th>Description</th>
                        <th class="text-end">Order</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($transactions as $tx)
                        @php $isEarned = $tx->type === 'earned'; @endphp
                        <tr>
                          <td data-label="Date" class="mv-nowrap">{{ $tx->created_at?->format('M d, Y') ?? '—' }}</td>
                          <td data-label="Type">
                            <span class="badge {{ $isEarned ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($tx->type) }}</span>
                          </td>
                          <td data-label="Points" class="mv-nowrap">
                            <span class="mv-cell-strong {{ $isEarned ? 'text-success' : '' }}">
                              {{ $isEarned ? '+' : '−' }}{{ number_format($tx->points) }}
                            </span>
                          </td>
                          <td data-label="Description">{{ $tx->description ?: '—' }}</td>
                          <td data-label="Order" class="text-end">
                            @if($tx->order_id)
                              <a href="{{ route('admin.orders.show', $tx->order_id) }}">View</a>
                            @else
                              <span class="text-muted">&mdash;</span>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endif
          </div>
        </div>

      </div>

      <!-- Right column -->
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              <span class="mv-avatar" style="width:52px;height:52px;font-size:1.1rem;">{{ $initials ?: 'M' }}</span>
              <div class="min-w-0">
                <div class="mv-cell-strong" style="font-size:1.05rem;">{{ $fullName }}</div>
                <div class="mv-cell-sub">Member #{{ $customer->id }}</div>
              </div>
            </div>

            <div class="mv-dl mv-dl-stack">
              <div class="mv-dl-row">
                <span class="mv-dl-key">First name</span>
                <span class="mv-dl-val">{{ $customer->first_name ?: '—' }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Middle name</span>
                <span class="mv-dl-val">{{ $customer->middle_name ?: '—' }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Last name</span>
                <span class="mv-dl-val">{{ $customer->last_name ?: '—' }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Email</span>
                <span class="mv-dl-val" style="word-break:break-all;">
                  <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                </span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Phone</span>
                <span class="mv-dl-val">
                  @if($customer->phone)
                    <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                  @else
                    —
                  @endif
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Address</h5>

            @if($fullAddress)
              <div class="mv-dl mv-dl-stack">
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Street</span>
                  <span class="mv-dl-val">{{ $customer->address ?: '—' }}</span>
                </div>
                <div class="mv-dl-row">
                  <span class="mv-dl-key">City</span>
                  <span class="mv-dl-val">{{ $customer->city ?: '—' }}</span>
                </div>
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Province / state</span>
                  <span class="mv-dl-val">{{ $customer->state ?: '—' }}</span>
                </div>
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Postal code</span>
                  <span class="mv-dl-val">{{ $customer->zip_code ?: '—' }}</span>
                </div>
              </div>
            @else
              <p class="mv-cell-sub mb-0">This member has not added an address.</p>
            @endif
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Account</h5>
            <div class="mv-dl mv-dl-stack">
              <div class="mv-dl-row">
                <span class="mv-dl-key">Joined</span>
                <span class="mv-dl-val">{{ $customer->created_at?->format('F d, Y · g:i A') ?? '—' }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Last updated</span>
                <span class="mv-dl-val">{{ $customer->updated_at?->format('F d, Y · g:i A') ?? '—' }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Points balance</span>
                <span class="mv-dl-val">{{ number_format($customer->loyalty_points) }} pts</span>
              </div>
            </div>
            <p class="mv-cell-sub mt-3 mb-0">
              Members edit their own profile and password from the website, so these details are read-only here.
            </p>
          </div>
        </div>

      </div>
    </div>

  </section>

</main>

@include('admin.inc.footer')
