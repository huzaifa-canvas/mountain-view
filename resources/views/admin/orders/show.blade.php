@include('admin.inc.header', ['pageTitle' => 'Order #' . $order->order_number])

@php
  $money = fn ($v) => $currency . ' ' . number_format((float) $v, 2);

  $isMember  = (bool) $order->customer_id;
  $guestName = $isMember
      ? trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? ''))
      : (trim($order->guest_first_name . ' ' . $order->guest_last_name) ?: $order->guest_name);
  $guestMail  = $isMember ? ($order->customer->email ?? null) : $order->guest_email;
  $guestPhone = $isMember ? ($order->customer->phone ?? null) : $order->guest_phone;

  $addressLine = implode(', ', array_filter([$order->guest_city, $order->guest_province, $order->guest_postal_code]));

  $firstIn  = $order->items->min('check_in');
  $lastOut  = $order->items->max('check_out');
  $isPaid   = $order->payment_status === 'paid';

  $stayState = $order->stayState();
  $stayLabel = $order->stayLabel();
  $isOut       = $stayState === 'checked_out';
  $isIn        = $stayState === 'checked_in';
  $isCancelled = $stayState === 'cancelled';
  $isNoShow    = $stayState === 'no_show';

  $stayTone = [
      'checked_out' => 'bg-secondary',
      'checked_in'  => 'bg-info',
      'cancelled'   => 'bg-danger',
      'no_show'     => 'bg-danger',
      'awaiting'    => 'bg-warning',
  ][$stayState];

  $stayIconTone = [
      'checked_out' => 'is-green',
      'checked_in'  => 'is-blue',
      'cancelled'   => '',
      'no_show'     => '',
      'awaiting'    => 'is-gold',
  ][$stayState];
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>Order #{{ $order->order_number }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions mv-no-print">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to orders
      </a>
      <button type="button" class="btn btn-primary" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Print
      </button>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mv-no-print" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mv-no-print" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">

    <!-- Summary strip -->
    <div class="row g-3 mb-1">
      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon {{ $isPaid ? 'is-green' : 'is-gold' }}"><i class="bi bi-credit-card"></i></span>
          <div>
            <div class="mv-stat-label">Payment</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">{{ ucfirst($order->payment_status) }}</div>
            <div class="mv-stat-meta">{{ $order->booking_type ?: 'Personal' }} booking</div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon"><i class="bi bi-cash-stack"></i></span>
          <div>
            <div class="mv-stat-label">Grand total</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">{{ $money($order->grand_total) }}</div>
            <div class="mv-stat-meta">incl. {{ $money($order->tax_amount) }} tax</div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon is-gold"><i class="bi bi-calendar-range"></i></span>
          <div>
            <div class="mv-stat-label">Stay window</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">
              @if($firstIn)
                {{ \Carbon\Carbon::parse($firstIn)->format('M d') }} &ndash; {{ \Carbon\Carbon::parse($lastOut)->format('M d') }}
              @else
                &mdash;
              @endif
            </div>
            <div class="mv-stat-meta">{{ $order->roomCount() }} {{ Str::plural('room', $order->roomCount()) }} booked</div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="mv-stat">
          <span class="mv-stat-icon {{ $stayIconTone }}">
            <i class="bi {{ $isCancelled ? 'bi-x-circle' : ($isNoShow ? 'bi-person-dash' : 'bi-house-door') }}"></i>
          </span>
          <div>
            <div class="mv-stat-label">Stay status</div>
            <div class="mv-stat-value" style="font-size:1.3rem;">{{ $stayLabel }}</div>
            <div class="mv-stat-meta">
              @if($isCancelled && $order->cancelled_at)
                {{ \Carbon\Carbon::parse($order->cancelled_at)->format('M d, Y g:i A') }}
              @elseif($isOut && $order->checked_out_at)
                {{ \Carbon\Carbon::parse($order->checked_out_at)->format('M d, Y g:i A') }}
              @elseif($isIn && $order->checked_in_at)
                {{ \Carbon\Carbon::parse($order->checked_in_at)->format('M d, Y g:i A') }}
              @elseif($isNoShow)
                Guest never arrived
              @else
                Confirmed {{ $order->created_at->format('M d, Y') }}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mt-1">

      <!-- Left column -->
      <div class="col-xl-8">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Booked rooms</h5>

            <div class="mv-table-wrap">
              <div class="table-responsive">
                <table class="table mv-responsive-table align-middle">
                  <thead>
                    <tr>
                      <th>Room</th>
                      <th>Dates</th>
                      <th>Rate</th>
                      <th class="text-end">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($order->items as $item)
                      <tr>
                        <td data-label="Room" class="mv-cell-block">
                          <span class="mv-cell-strong">{{ $item->listing_name }}</span>
                          <div class="mv-facts mt-1">
                            <span class="mv-fact"><i class="bi bi-door-closed"></i> {{ $item->rooms }} {{ Str::plural('room', $item->rooms) }}</span>
                            <span class="mv-fact"><i class="bi bi-moon"></i> {{ $item->nights }} {{ Str::plural('night', $item->nights) }}</span>
                            <span class="mv-fact"><i class="bi bi-heart"></i> {{ $item->pets ?: '0' }} pets</span>
                            <span class="mv-fact"><i class="bi bi-basket"></i> {{ $item->laundry ?: 'No laundry' }}</span>
                          </div>
                        </td>
                        <td data-label="Dates" class="mv-cell-block mv-nowrap">
                          <span class="mv-cell-strong">{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</span>
                          <div class="mv-cell-sub">to {{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</div>
                        </td>
                        <td data-label="Rate" class="mv-nowrap"><span>{{ $money($item->price_per_night) }} <span class="mv-cell-sub">/ night</span></span></td>
                        <td data-label="Total" class="text-end mv-nowrap"><span class="mv-cell-strong">{{ $money($item->item_total) }}</span></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row">
              <div class="col-md-7 ms-auto">
                <div class="mv-totals">
                  @if(($order->pet_fee_total ?? 0) > 0)
                    <div class="mv-totals-row"><span>Pet fees</span><span>{{ $money($order->pet_fee_total) }}</span></div>
                  @endif
                  @if(($order->laundry_fee_total ?? 0) > 0)
                    <div class="mv-totals-row"><span>Laundry fees</span><span>{{ $money($order->laundry_fee_total) }}</span></div>
                  @endif
                  <div class="mv-totals-row"><span>Subtotal</span><span>{{ $money($order->subtotal) }}</span></div>
                  <div class="mv-totals-row"><span>Tax</span><span>{{ $money($order->tax_amount) }}</span></div>
                  @if($order->loyalty_discount > 0)
                    <div class="mv-totals-row is-credit"><span>Loyalty discount</span><span>&minus;{{ $money($order->loyalty_discount) }}</span></div>
                  @endif
                  <div class="mv-totals-row is-grand"><span>Grand total</span><span>{{ $money($order->grand_total) }}</span></div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Change the dates -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Change dates</h5>

            @php
              $curIn  = $order->items->min('check_in');
              $curOut = $order->items->max('check_out');
              $curNights = $curIn && $curOut
                  ? (int) \Carbon\Carbon::parse($curIn)->diffInDays(\Carbon\Carbon::parse($curOut))
                  : 0;
            @endphp

            <p class="text-muted mb-3" style="font-size:13px;">
              Staff can move a booking to any dates, including past ones, and change how long it runs.
              The rooms still have to be free &mdash; the desk cannot double-book a night.
            </p>

            <form method="POST" action="{{ route('admin.orders.update-dates', $order->id) }}" id="admin-dates-form">
              @csrf
              <div class="row g-3 align-items-end">
                <div class="col-md-4">
                  <label class="form-label" for="ad_check_in">Check in</label>
                  <input type="text" class="form-control" id="ad_check_in" name="check_in" autocomplete="off"
                         value="{{ old('check_in', $curIn ? \Carbon\Carbon::parse($curIn)->toDateString() : '') }}" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="ad_check_out">Check out</label>
                  <input type="text" class="form-control" id="ad_check_out" name="check_out" autocomplete="off"
                         value="{{ old('check_out', $curOut ? \Carbon\Carbon::parse($curOut)->toDateString() : '') }}" required>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-primary w-100" id="admin-dates-open">
                    <i class="bi bi-calendar-check"></i> Update dates
                  </button>
                </div>
              </div>

              <div class="mv-dates-preview mt-3" id="admin-dates-preview">
                Currently <strong>{{ $curNights }} {{ Str::plural('night', $curNights) }}</strong>,
                total {{ $currency }} {{ number_format($order->grand_total, 2) }}.
              </div>
            </form>
          </div>
        </div>

        <div class="modal fade" id="adminDatesModal" tabindex="-1" aria-labelledby="adminDatesLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="adminDatesLabel">Change these dates?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mv-confirm-grid">
                  <div>
                    <div class="mv-confirm-label">Currently</div>
                    <div class="mv-confirm-dates">
                      {{ $curIn ? \Carbon\Carbon::parse($curIn)->format('M d') : '' }}
                      &rarr;
                      {{ $curOut ? \Carbon\Carbon::parse($curOut)->format('M d, Y') : '' }}
                    </div>
                    <div class="mv-confirm-sub">
                      {{ $curNights }} {{ Str::plural('night', $curNights) }}
                      &middot; {{ $currency }} {{ number_format($order->grand_total, 2) }}
                    </div>
                  </div>
                  <i class="bi bi-arrow-right mv-confirm-arrow"></i>
                  <div>
                    <div class="mv-confirm-label">Changing to</div>
                    <div class="mv-confirm-dates" id="confirm-new-dates">&mdash;</div>
                    <div class="mv-confirm-sub" id="confirm-new-sub">&mdash;</div>
                  </div>
                </div>

                <p class="mb-0 mt-3" id="confirm-money" style="font-size:13px;"></p>

                <p class="mb-0 mt-2 text-muted" style="font-size:12px;">
                  The rooms are checked again when this is saved. If they are not free for the new dates,
                  nothing will change.
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keep the current dates</button>
                <button type="submit" form="admin-dates-form" class="btn btn-primary" id="admin-dates-btn">
                  <i class="bi bi-check2"></i> Yes, update
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Booking timeline -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Booking timeline</h5>
            <ul class="mv-timeline">
              <li class="is-done">
                <div class="mv-timeline-title">Booking placed</div>
                <div class="mv-timeline-meta">{{ $order->created_at->format('F d, Y · g:i A') }}</div>
              </li>
              <li class="{{ $isPaid ? 'is-done' : '' }}">
                <div class="mv-timeline-title">Payment {{ $isPaid ? 'received' : ucfirst($order->payment_status) }}</div>
                <div class="mv-timeline-meta">
                  {{ $order->stripe_payment_intent_id ? 'Stripe · ' . $order->stripe_payment_intent_id : 'No Stripe reference recorded' }}
                </div>
              </li>

              {{-- Oldest first here, so the timeline reads forwards --}}
              @foreach($order->changes->sortBy('created_at') as $change)
                <li class="is-done">
                  <div class="mv-timeline-title">
                    Dates moved by {{ $change->changed_by === 'admin' ? 'staff' : 'the guest' }}
                    @if($change->changed_by_name)
                      <span class="text-muted">&middot; {{ $change->changed_by_name }}</span>
                    @endif
                  </div>
                  <div class="mv-timeline-meta">{{ $change->created_at->format('F d, Y · g:i A') }}</div>
                  <div class="mv-timeline-note">
                    {{ $change->from_check_in->format('M d') }} &rarr; {{ $change->from_check_out->format('M d, Y') }}
                    became
                    {{ $change->to_check_in->format('M d') }} &rarr; {{ $change->to_check_out->format('M d, Y') }}
                    @php
                        $shift = $change->shiftInDays();
                        $wasNights = (int) $change->from_check_in->diffInDays($change->from_check_out);
                        $nowNights = (int) $change->to_check_in->diffInDays($change->to_check_out);

                        $words = $shift === 0
                            ? 'same arrival'
                            : ($shift > 0 ? 'moved back ' : 'brought forward ')
                                . abs($shift) . ' ' . Str::plural('day', abs($shift));

                        // Staff can change the length as well, which changes the
                        // price; a guest never can, so only say so when it is true.
                        if ($wasNights !== $nowNights) {
                            $words .= ', ' . $wasNights . ' ' . Str::plural('night', $wasNights)
                                . ' became ' . $nowNights . ' ' . Str::plural('night', $nowNights);
                        }

                        $diff = $change->totalDifference();
                    @endphp
                    ({{ $words }})

                    @if($diff !== null)
                      <div class="mv-change-money">
                        @if(abs($diff) < 0.01)
                          Total unchanged at <strong>{{ $currency }} {{ number_format($change->to_total, 2) }}</strong>.
                        @else
                          Total went from <strong>{{ $currency }} {{ number_format($change->from_total, 2) }}</strong>
                          to <strong>{{ $currency }} {{ number_format($change->to_total, 2) }}</strong> &mdash;
                          @if($diff > 0)
                            <span class="mv-money-up">{{ $currency }} {{ number_format($diff, 2) }} to collect from the guest.</span>
                          @else
                            <span class="mv-money-down">{{ $currency }} {{ number_format(abs($diff), 2) }} to refund in Stripe.</span>
                          @endif
                        @endif
                      </div>
                    @endif
                  </div>
                </li>
              @endforeach
              @if($isCancelled)
                <li class="is-cancelled">
                  <div class="mv-timeline-title">Booking cancelled</div>
                  <div class="mv-timeline-meta">
                    {{ $order->cancelled_at ? \Carbon\Carbon::parse($order->cancelled_at)->format('F d, Y · g:i A') : 'Date not recorded' }}
                  </div>
                  @if($order->cancellation_reason)
                    <div class="mv-timeline-note">{{ $order->cancellation_reason }}</div>
                  @endif
                </li>
              @else
                <li class="{{ $isIn || $isOut ? 'is-done' : ($isNoShow ? 'is-cancelled' : 'is-active') }}">
                  <div class="mv-timeline-title">
                    @if($isIn || $isOut) Guest checked in
                    @elseif($isNoShow) Guest never arrived
                    @else Awaiting arrival
                    @endif
                  </div>
                  <div class="mv-timeline-meta">
                    @if($order->checked_in_at)
                      {{ \Carbon\Carbon::parse($order->checked_in_at)->format('F d, Y · g:i A') }}
                    @elseif($isNoShow)
                      No check-in was recorded before the stay ended
                    @elseif($isOut)
                      Arrival was not recorded for this booking
                    @elseif($firstIn)
                      Scheduled arrival {{ \Carbon\Carbon::parse($firstIn)->format('F d, Y') }}
                    @else
                      No arrival date on this booking
                    @endif
                  </div>
                </li>
                <li class="{{ $isOut ? 'is-done' : ($isIn ? 'is-active' : '') }}">
                  <div class="mv-timeline-title">
                    {{ $isOut ? 'Guest checked out' : ($isNoShow ? 'Stay window closed' : 'Awaiting checkout') }}
                  </div>
                  <div class="mv-timeline-meta">
                    @if($isOut && $order->checked_out_at)
                      {{ \Carbon\Carbon::parse($order->checked_out_at)->format('F d, Y · g:i A') }}
                    @elseif($lastOut)
                      {{ $isNoShow ? 'Ended' : 'Scheduled departure' }} {{ \Carbon\Carbon::parse($lastOut)->format('F d, Y') }}
                    @else
                      Awaiting checkout
                    @endif
                  </div>
                </li>
              @endif
            </ul>
          </div>
        </div>

      </div>

      <!-- Right column: actions first, since that is what the front desk acts on -->
      <div class="col-xl-4">

        <div class="card mv-no-print">
          <div class="card-body">
            <h5 class="card-title d-flex align-items-center justify-content-between">
              Actions
              <span class="badge {{ $stayTone }}">{{ $stayLabel }}</span>
            </h5>

            @if($order->canCheckIn())
              <form action="{{ route('admin.orders.mark-checked-in', $order->id) }}" method="POST"
                    onsubmit="return confirm('Check this guest in now?');">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-box-arrow-in-left me-1"></i> Mark as checked in
                </button>
              </form>
            @elseif($order->canCheckOut())
              <form action="{{ route('admin.orders.mark-checked-out', $order->id) }}" method="POST"
                    onsubmit="return confirm('Mark this booking as checked out? A thank-you and feedback email will be sent to the guest.');">
                @csrf
                <button type="submit" class="btn btn-success w-100">
                  <i class="bi bi-box-arrow-right me-1"></i> Mark as checked out
                </button>
              </form>
              <p class="mv-cell-sub mt-2 mb-0">
                Checked in {{ $order->checked_in_at ? \Carbon\Carbon::parse($order->checked_in_at)->format('M d, Y · g:i A') : '—' }}
              </p>
            @elseif($isCancelled)
              <button class="btn btn-secondary w-100" disabled>
                <i class="bi bi-x-circle me-1"></i> Booking cancelled
              </button>
              <p class="mv-cell-sub mt-2 mb-0">
                Cancelled {{ $order->cancelled_at ? \Carbon\Carbon::parse($order->cancelled_at)->format('M d, Y · g:i A') : '—' }}
              </p>
            @elseif($isNoShow)
              <button class="btn btn-secondary w-100" disabled>
                <i class="bi bi-person-dash me-1"></i> Guest never arrived
              </button>
              <p class="mv-cell-sub mt-2 mb-0">
                The stay ended {{ $lastOut ? \Carbon\Carbon::parse($lastOut)->format('M d, Y') : '' }} without a check-in,
                so it can no longer be checked in or out.
              </p>
            @else
              <button class="btn btn-secondary w-100" disabled>
                <i class="bi bi-check-circle me-1"></i> Stay complete
              </button>
              <p class="mv-cell-sub mt-2 mb-0">
                Checked out {{ $order->checked_out_at ? \Carbon\Carbon::parse($order->checked_out_at)->format('M d, Y · g:i A') : '—' }}
              </p>
            @endif

            @if($order->canCancel())
              <button type="button" class="btn btn-outline-danger w-100 mt-2"
                      data-bs-toggle="modal" data-bs-target="#cancelBookingModal">
                <i class="bi bi-x-circle me-1"></i> Cancel booking
              </button>
            @endif

            <hr>

            {{-- A stay reminder only makes sense while the stay is still ahead
                 or under way; not for cancelled, missed or finished bookings. --}}
            @if(in_array($stayState, ['awaiting', 'checked_in'], true))
              <form action="{{ route('admin.orders.send-reminder', $order->id) }}" method="POST"
                    onsubmit="return confirm('Send a booking reminder email to this guest?');">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                  <i class="bi bi-envelope-paper me-1"></i> Send reminder email
                </button>
              </form>
            @endif

            @if($guestMail)
              <a href="mailto:{{ $guestMail }}" class="btn btn-outline-secondary w-100 mt-2">
                <i class="bi bi-envelope me-1"></i> Email guest directly
              </a>
            @endif
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex align-items-center justify-content-between">
              Guest
              <span class="badge {{ $isMember ? 'bg-info' : 'bg-secondary' }}">{{ $isMember ? 'Member' : 'Guest' }}</span>
            </h5>

            <div class="mv-dl">
              <div class="mv-dl-row">
                <span class="mv-dl-key">Name</span>
                <span class="mv-dl-val">
                  @if($isMember && $order->customer)
                    <a href="{{ route('admin.members.show', $order->customer_id) }}">{{ $guestName ?: '—' }}</a>
                  @else
                    {{ $guestName ?: '—' }}
                  @endif
                </span>
              </div>
              <div class="mv-dl-row"><span class="mv-dl-key">Email</span><span class="mv-dl-val">{{ $guestMail ?: '—' }}</span></div>
              <div class="mv-dl-row"><span class="mv-dl-key">Phone</span><span class="mv-dl-val">{{ $guestPhone ?: '—' }}</span></div>
              @if($isMember)
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Points balance</span>
                  <span class="mv-dl-val">{{ number_format($order->customer->loyalty_points ?? 0) }} pts</span>
                </div>
              @endif
              @if($order->guest_address || $addressLine)
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Address</span>
                  <span class="mv-dl-val">{{ implode(', ', array_filter([$order->guest_address, $addressLine])) ?: '—' }}</span>
                </div>
              @endif
              @if($order->guest_vehicle_number)
                <div class="mv-dl-row"><span class="mv-dl-key">Vehicle</span><span class="mv-dl-val">{{ $order->guest_vehicle_number }}</span></div>
              @endif
            </div>

            @if($isMember && $order->customer)
              <a href="{{ route('admin.members.show', $order->customer_id) }}"
                 class="btn btn-outline-secondary w-100 mt-3">
                <i class="bi bi-person-lines-fill me-1"></i> Open member profile
              </a>
            @endif

            @if($order->guest_id_proof)
              @php $ext = strtolower(pathinfo($order->guest_id_proof, PATHINFO_EXTENSION)); @endphp
              <hr>
              <div class="mv-eyebrow mb-2">Uploaded ID proof</div>
              @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                <a href="{{ asset($order->guest_id_proof) }}" target="_blank" rel="noopener" class="d-block mb-2">
                  <img src="{{ asset($order->guest_id_proof) }}" alt="Uploaded ID proof"
                       class="img-fluid" style="max-height:170px;border-radius:var(--mv-radius-sm);border:1px solid var(--mv-border);">
                </a>
              @endif
              <a href="{{ asset($order->guest_id_proof) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary w-100">
                <i class="bi bi-file-earmark-text me-1"></i> Open ID file
              </a>
            @endif
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Payment</h5>
            <div class="mv-dl">
              <div class="mv-dl-row">
                <span class="mv-dl-key">Status</span>
                <span class="mv-dl-val">
                  @if($isPaid)
                    <span class="badge bg-success">Paid</span>
                  @else
                    <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span>
                  @endif
                </span>
              </div>
              <div class="mv-dl-row"><span class="mv-dl-key">Booking type</span><span class="mv-dl-val">{{ $order->booking_type ?: 'Personal' }}</span></div>
              <div class="mv-dl-row"><span class="mv-dl-key">Placed on</span><span class="mv-dl-val">{{ $order->created_at->format('M d, Y g:i A') }}</span></div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">PaymentIntent</span>
                <span class="mv-dl-val" style="font-size:.78rem;">{{ $order->stripe_payment_intent_id ?: '—' }}</span>
              </div>
              @if($order->stripe_charge_id)
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Charge</span>
                  <span class="mv-dl-val" style="font-size:.78rem;">{{ $order->stripe_charge_id }}</span>
                </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    @if($order->notes)
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Notes</h5>
          <p class="mb-0" style="color:var(--mv-text-2);">{{ $order->notes }}</p>
        </div>
      </div>
    @endif

  </section>

</main>

  @if($order->canCancel())
    <!-- Cancellation asks for a reason, because it is the only record of why -->
    <div class="modal fade mv-no-print" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST" action="{{ route('admin.orders.cancel', $order->id) }}">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="cancelBookingLabel">Cancel booking #{{ $order->order_number }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <p style="font-size:.9rem;color:var(--mv-text-2);">
              This marks the stay as cancelled for
              <strong>{{ $guestName ?: 'this guest' }}</strong>{{ $firstIn ? ' (' . \Carbon\Carbon::parse($firstIn)->format('M d, Y') . ')' : '' }}.
              It does not refund the payment &mdash; issue any refund in Stripe.
            </p>

            <label class="form-label" for="cancellation_reason">Reason for cancelling <span class="text-danger">*</span></label>
            <textarea class="form-control @error('cancellation_reason') is-invalid @enderror"
                      id="cancellation_reason" name="cancellation_reason" rows="4" required minlength="5" maxlength="1000"
                      placeholder="e.g. Guest called to cancel — family emergency">{{ old('cancellation_reason') }}</textarea>
            @error('cancellation_reason')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <p class="mv-cell-sub mt-2 mb-0">This reason is saved and shown on the booking timeline.</p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keep booking</button>
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-x-circle me-1"></i> Cancel booking
            </button>
          </div>
        </form>
      </div>
    </div>
    @error('cancellation_reason')
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var el = document.getElementById('cancelBookingModal');
          if (el && window.bootstrap) new bootstrap.Modal(el).show();
        });
      </script>
    @enderror
  @endif

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
  .mv-dates-preview {
    font-size: 13px; font-weight: 600; color: var(--mv-text-2);
    background: var(--mv-surface-2); border: 1px solid var(--mv-border);
    border-radius: 10px; padding: 11px 15px;
  }
  .mv-dates-preview strong { color: var(--mv-text); }
  .mv-dates-preview .is_more { color: var(--mv-danger); }
  .mv-dates-preview .is_less { color: var(--mv-success); }
  .mv-confirm-grid {
    display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
    background: var(--mv-surface-2); border: 1px solid var(--mv-border);
    border-radius: 12px; padding: 14px 18px;
  }
  .mv-confirm-label {
    font-size: 11px; font-weight: 700; color: var(--mv-muted);
    text-transform: uppercase; letter-spacing: .6px; margin-bottom: 4px;
  }
  .mv-confirm-dates { font-size: 15px; font-weight: 800; color: var(--mv-text); }
  .mv-confirm-sub { font-size: 12px; color: var(--mv-text-2); margin-top: 2px; }
  .mv-confirm-arrow { color: var(--mv-brand); font-size: 18px; }
  .mv-change-money {
    margin-top: 6px; font-size: 12px; color: var(--mv-text-2);
  }
  .mv-change-money strong { color: var(--mv-text); }
  .mv-money-up { color: var(--mv-danger); font-weight: 700; }
  .mv-money-down { color: var(--mv-success); font-weight: 700; }
</style>

<script>
(function () {
  var inEl  = document.getElementById('ad_check_in');
  var outEl = document.getElementById('ad_check_out');
  if (!inEl || !outEl) return;

  var preview = document.getElementById('admin-dates-preview');
  var CURRENCY = @json($currency);
  var TAX_RATE = {{ (float) (DB::table('general_setting')->where('general_setting_id','1')->value('tax_rate') ?? 15) }};
  var EXTRAS   = {{ (float) $order->pet_fee_total + (float) $order->laundry_fee_total }};
  var DISCOUNT = {{ (float) $order->loyalty_discount }};
  var PER_NIGHT = {{ (float) $order->items->sum(fn ($i) => $i->price_per_night * $i->rooms) }};
  var CUR_NIGHTS = {{ $curNights }};
  var CUR_TOTAL = {{ (float) $order->grand_total }};

  function money(n) { return CURRENCY + ' ' + n.toFixed(2); }

  function nights() {
    if (!inEl.value || !outEl.value) return 0;
    var d = Math.round((new Date(outEl.value) - new Date(inEl.value)) / 86400000);
    return d > 0 ? d : 0;
  }

  // Shows what the booking would come to, so staff know before they save
  // whether money needs collecting or refunding.
  function update() {
    var n = nights();
    if (!n) { preview.innerHTML = 'Check-out has to be after check-in.'; return; }

    var sub = PER_NIGHT * n + EXTRAS;
    var total = Math.max(0, sub + sub * (TAX_RATE / 100) - DISCOUNT);
    var diff = total - CUR_TOTAL;

    var html = '<strong>' + n + (n === 1 ? ' night' : ' nights') + '</strong>, total <strong>' + money(total) + '</strong>';

    if (Math.abs(diff) < 0.01) {
      html += ' &mdash; unchanged.';
    } else if (diff > 0) {
      html += ' &mdash; <span class="is_more">' + money(diff) + ' more to collect</span> than the ' + money(CUR_TOTAL) + ' already on this booking.';
    } else {
      html += ' &mdash; <span class="is_less">' + money(-diff) + ' to refund</span> against the ' + money(CUR_TOTAL) + ' already on this booking.';
    }

    preview.innerHTML = html;
  }

  var outPicker = flatpickr(outEl, {
    dateFormat: 'Y-m-d', altInput: true, altFormat: 'M j, Y',
    onChange: update
  });

  // No minDate anywhere: staff may need to correct a stay that has already
  // happened, which a guest never can.
  flatpickr(inEl, {
    dateFormat: 'Y-m-d', altInput: true, altFormat: 'M j, Y',
    onChange: function (dates) {
      if (dates.length) {
        var next = new Date(dates[0]);
        next.setDate(next.getDate() + 1);
        if (!outPicker.selectedDates[0] || outPicker.selectedDates[0] <= dates[0]) {
          outPicker.setDate(next, false);
        }
      }
      update();
    }
  });

  // The dialog restates what is about to happen, including the money, so a
  // mis-typed date is caught before the booking moves.
  var CUR_IN = @json($curIn ? \Carbon\Carbon::parse($curIn)->toDateString() : '');
  var CUR_OUT = @json($curOut ? \Carbon\Carbon::parse($curOut)->toDateString() : '');

  document.getElementById('admin-dates-open').addEventListener('click', function () {
    var n = nights();

    if (!n) {
      preview.innerHTML = 'Check-out has to be after check-in.';
      return;
    }

    if (inEl.value === CUR_IN && outEl.value === CUR_OUT) {
      preview.innerHTML = 'Those are already this booking\'s dates.';
      return;
    }

    var sub = PER_NIGHT * n + EXTRAS;
    var total = Math.max(0, sub + sub * (TAX_RATE / 100) - DISCOUNT);
    var diff = total - CUR_TOTAL;

    document.getElementById('confirm-new-dates').textContent =
      inEl._flatpickr.altInput.value + '  \u2192  ' + outEl._flatpickr.altInput.value;
    document.getElementById('confirm-new-sub').textContent =
      n + (n === 1 ? ' night' : ' nights') + '  \u00b7  ' + money(total);

    var money_line = document.getElementById('confirm-money');
    if (Math.abs(diff) < 0.01) {
      money_line.className = 'mb-0 mt-3 text-muted';
      money_line.textContent = 'The total does not change, so there is nothing to collect or refund.';
    } else if (diff > 0) {
      money_line.className = 'mb-0 mt-3 fw-bold text-danger';
      money_line.textContent = 'You will need to collect ' + money(diff) + ' more from the guest.';
    } else {
      money_line.className = 'mb-0 mt-3 fw-bold text-success';
      money_line.textContent = 'You will need to refund ' + money(-diff) + ' in Stripe.';
    }

    new bootstrap.Modal(document.getElementById('adminDatesModal')).show();
  });

  document.getElementById('admin-dates-form').addEventListener('submit', function () {
    var btn = document.getElementById('admin-dates-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Saving\u2026';
  });

  update();
})();
</script>

@include('admin.inc.footer')
