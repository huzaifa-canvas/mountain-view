@include('front.inc.header')

@php
    $state = $order->stayState();

    $tone = match ($state) {
        'cancelled'   => ['bg' => '#FEE2E2', 'fg' => '#991B1B', 'icon' => 'fa-circle-xmark'],
        'checked_out' => ['bg' => '#E2E8F0', 'fg' => '#334155', 'icon' => 'fa-circle-check'],
        'checked_in'  => ['bg' => '#DCFCE7', 'fg' => '#166534', 'icon' => 'fa-house-user'],
        'no_show'     => ['bg' => '#FEF3C7', 'fg' => '#92400E', 'icon' => 'fa-user-slash'],
        default       => ['bg' => '#DBEAFE', 'fg' => '#1E40AF', 'icon' => 'fa-clock'],
    };

    $firstIn  = $order->items->min('check_in');
    $lastOut  = $order->items->max('check_out');
    $nights   = (int) $order->items->sum('nights');
    $guestName = $order->guest_name
        ?: trim($order->guest_first_name . ' ' . $order->guest_last_name)
        ?: trim($customer->first_name . ' ' . $customer->last_name);
    $guestEmail = $order->guest_email ?: $customer->email;
    $guestPhone = $order->guest_phone ?: $customer->phone;

    $address  = implode(', ', array_filter([
        $order->guest_address, $order->guest_city, $order->guest_province, $order->guest_postal_code,
    ]));
@endphp

<style>
    .bk_wrapper {
        padding: 55px 0 90px;
        background-color: #F8FAFC;
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    }
    .bk_back {
        display: inline-flex; align-items: center; gap: 8px;
        color: #64748B; font-weight: 600; font-size: 14px;
        text-decoration: none; margin-bottom: 18px;
    }
    .bk_back:hover { color: #184E77; }
    .bk_card {
        background: #fff; border: 1px solid #E2E8F0; border-radius: 16px;
        padding: 26px; margin-bottom: 22px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    }
    .bk_card_title {
        font-size: 15px; font-weight: 800; color: #0F172A;
        text-transform: uppercase; letter-spacing: .6px;
        margin: 0 0 18px; padding-bottom: 14px; border-bottom: 1px solid #EEF2F7;
        display: flex; align-items: center; gap: 9px;
    }
    .bk_card_title i { color: #184E77; }
    .bk_head {
        display: flex; flex-wrap: wrap; gap: 14px;
        align-items: center; justify-content: space-between;
    }
    .bk_ref { font-size: 22px; font-weight: 800; color: #0F172A; margin: 0; }
    .bk_placed { font-size: 13px; color: #64748B; margin: 4px 0 0; }
    .bk_badge {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 8px 16px; border-radius: 30px;
        font-size: 13px; font-weight: 700;
    }
    .bk_badge_sm { padding: 5px 12px; font-size: 12px; }
    .bk_grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 18px; }
    .bk_fact_label {
        font-size: 11px; font-weight: 700; color: #94A3B8;
        text-transform: uppercase; letter-spacing: .7px; margin-bottom: 5px;
    }
    .bk_fact_value { font-size: 15px; font-weight: 700; color: #0F172A; word-break: break-word; }
    .bk_room {
        display: flex; flex-wrap: wrap; gap: 14px; justify-content: space-between;
        padding: 16px 0; border-bottom: 1px dashed #E2E8F0;
    }
    .bk_room:last-child { border-bottom: 0; padding-bottom: 0; }
    .bk_room_name { font-size: 16px; font-weight: 700; color: #0F172A; margin-bottom: 6px; }
    .bk_room_meta { font-size: 13px; color: #64748B; }
    .bk_room_meta span + span::before { content: '·'; margin: 0 8px; color: #CBD5E1; }
    .bk_total_row {
        display: flex; justify-content: space-between; gap: 16px;
        font-size: 14px; color: #475569; padding: 7px 0;
    }
    .bk_total_row.is_grand {
        border-top: 2px solid #0F172A; margin-top: 10px; padding-top: 14px;
        font-size: 19px; font-weight: 800; color: #0F172A;
    }
    .bk_note {
        background: #FEF2F2; border: 1px solid #FECACA; border-radius: 12px;
        padding: 16px 18px; color: #7F1D1D; font-size: 14px;
    }
    .bk_note strong { display: block; margin-bottom: 4px; }
    .bk_move_compare {
        display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
        background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px;
        padding: 14px 18px; margin-bottom: 16px;
    }
    .bk_move_dates { font-size: 15px; font-weight: 800; color: #0F172A; }
    .bk_move_arrow { color: #184E77; }
    .bk_log { list-style: none; margin: 0; padding: 0; }
    .bk_log li {
        padding: 12px 0; border-bottom: 1px dashed #E2E8F0;
        display: flex; flex-wrap: wrap; gap: 4px 12px; align-items: baseline;
    }
    .bk_log li:last-child { border-bottom: 0; padding-bottom: 0; }
    .bk_log_when {
        font-size: 12px; font-weight: 700; color: #94A3B8;
        min-width: 155px;
    }
    .bk_log_what { font-size: 14px; color: #475569; flex: 1 1 260px; }
    .bk_log_who { font-size: 12px; font-weight: 700; color: #184E77; }
    .bk_move_form {
        display: flex; flex-wrap: wrap; align-items: flex-end; gap: 14px;
    }
    .bk_derived {
        font-size: 15px; font-weight: 700; color: #0F172A;
        background: #F1F5F9; border: 1px solid #E2E8F0; border-radius: 10px;
        padding: 9px 16px; min-width: 150px;
    }
    .bk_btn_move {
        background: #184E77; border: 0; color: #fff; font-weight: 700;
        border-radius: 30px; padding: 11px 24px; font-size: 14px;
        display: inline-flex; align-items: center; gap: 9px;
    }
    .bk_btn_move:hover { background: #123A59; color: #fff; }
    .bk_btn_move:disabled { background: #94A3B8; cursor: not-allowed; }
    .bk_move_closed {
        display: flex; align-items: flex-start; gap: 12px;
        background: #FEF3C7; border: 1px solid #FDE68A; border-radius: 12px;
        padding: 14px 17px; font-size: 14px; color: #78350F; line-height: 1.5;
    }
    .bk_move_closed i { margin-top: 3px; flex: 0 0 auto; }
    .bk_move_closed strong { display: block; margin-bottom: 2px; }
    .bk_move_msg {
        flex: 1 1 100%; margin: 4px 0 0;
        font-size: 13px; font-weight: 700; color: #B45309;
    }
    .flatpickr-day { position: relative; }
    .mv-day-left {
        position: absolute; left: 0; right: 0; bottom: 1px;
        font-size: 9px; line-height: 1; font-weight: 600;
        color: #0F7B6C; pointer-events: none;
    }
    .mv-day-left.is_full { color: #C62F14; }
    .flatpickr-day.flatpickr-disabled .mv-day-left { opacity: .45; }
    .bk_btn_danger {
        background: #DC2626; border: 0; color: #fff; font-weight: 700;
        border-radius: 30px; padding: 12px 26px; font-size: 14px;
        display: inline-flex; align-items: center; gap: 9px;
    }
    .bk_btn_danger:hover { background: #B91C1C; color: #fff; }
    .bk_policy { font-size: 13px; color: #64748B; margin: 12px 0 0; }
    @media (max-width: 575px) {
        .bk_card { padding: 20px 17px; }
        .bk_ref { font-size: 18px; }
    }
</style>

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">BOOKING DETAILS</h6>
        </div>
    </div>
</section>

<section class="bk_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

                <a href="{{ route('customer.dashboard') }}" class="bk_back">
                    <i class="fa-solid fa-arrow-left"></i> Back to my account
                </a>

                @if(session('success'))
                    <div class="alert alert-success" style="border-radius:12px;">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" style="border-radius:12px;">{{ session('error') }}</div>
                @endif

                <div class="bk_card">
                    <div class="bk_head">
                        <div>
                            <h1 class="bk_ref">#{{ $order->order_number }}</h1>
                            <p class="bk_placed">Booked on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="bk_badge" style="background: {{ $tone['bg'] }}; color: {{ $tone['fg'] }};">
                                <i class="fa-solid {{ $tone['icon'] }}"></i> {{ $order->stayLabel() }}
                            </span>
                            <span class="bk_badge" style="background: {{ $order->payment_status === 'paid' ? '#DCFCE7' : '#FEF3C7' }}; color: {{ $order->payment_status === 'paid' ? '#166534' : '#92400E' }};">
                                <i class="fa-solid fa-credit-card"></i> {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($state === 'cancelled')
                    <div class="bk_card">
                        <div class="bk_note">
                            <strong><i class="fa-solid fa-circle-xmark me-1"></i> This booking was cancelled{{ $order->cancelled_at ? ' on ' . \Carbon\Carbon::parse($order->cancelled_at)->format('F d, Y') : '' }}.</strong>
                            @if($order->cancellation_reason)
                                Reason: {{ $order->cancellation_reason }}
                            @endif
                            @if($order->payment_status === 'paid')
                                <div class="mt-2">Any refund due on this booking is handled by our team — please contact us if you have not heard from us.</div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="bk_card">
                    <h2 class="bk_card_title"><i class="fa-solid fa-calendar-days"></i> Your stay</h2>
                    <div class="bk_grid">
                        <div>
                            <div class="bk_fact_label">Check in</div>
                            <div class="bk_fact_value">{{ $firstIn ? \Carbon\Carbon::parse($firstIn)->format('D, M d, Y') : '—' }}</div>
                        </div>
                        <div>
                            <div class="bk_fact_label">Check out</div>
                            <div class="bk_fact_value">{{ $lastOut ? \Carbon\Carbon::parse($lastOut)->format('D, M d, Y') : '—' }}</div>
                        </div>
                        <div>
                            <div class="bk_fact_label">Nights</div>
                            <div class="bk_fact_value">{{ $nights }}</div>
                        </div>
                        <div>
                            <div class="bk_fact_label">Rooms</div>
                            <div class="bk_fact_value">{{ $order->roomCount() }}</div>
                        </div>
                        <div>
                            <div class="bk_fact_label">Booking type</div>
                            <div class="bk_fact_value">{{ $order->booking_type ?? 'Personal' }}</div>
                        </div>
                        @if($order->checked_in_at)
                            <div>
                                <div class="bk_fact_label">Checked in at</div>
                                <div class="bk_fact_value">{{ \Carbon\Carbon::parse($order->checked_in_at)->format('M d, g:i A') }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($order->changes->isNotEmpty())
                    <div class="bk_card">
                        <h2 class="bk_card_title"><i class="fa-solid fa-clock-rotate-left"></i> Changes to this booking</h2>
                        <ul class="bk_log">
                            @foreach($order->changes as $change)
                                <li>
                                    <span class="bk_log_when">{{ $change->created_at->format('M d, Y g:i A') }}</span>
                                    <span class="bk_log_what">
                                        Dates moved from
                                        <strong>{{ $change->from_check_in->format('M d') }} &rarr; {{ $change->from_check_out->format('M d, Y') }}</strong>
                                        to
                                        <strong>{{ $change->to_check_in->format('M d') }} &rarr; {{ $change->to_check_out->format('M d, Y') }}</strong>
                                    </span>
                                    <span class="bk_log_who">
                                        by {{ $change->changed_by === 'admin' ? 'our team' : 'you' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bk_card">
                    <h2 class="bk_card_title"><i class="fa-solid fa-bed"></i> Rooms booked</h2>
                    @foreach($order->items as $item)
                        <div class="bk_room">
                            <div>
                                <div class="bk_room_name">{{ $item->listing_name }}</div>
                                <div class="bk_room_meta">
                                    <span>{{ $item->rooms }} {{ Str::plural('room', $item->rooms) }}</span>
                                    <span>{{ $item->nights }} {{ Str::plural('night', $item->nights) }}</span>
                                    <span>{{ \Carbon\Carbon::parse($item->check_in)->format('M d') }} &rarr; {{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="text-md-end">
                                <div class="bk_fact_label">Line total</div>
                                <div class="bk_fact_value">{{ $currency }} {{ number_format($item->item_total, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="bk_card">
                            <h2 class="bk_card_title"><i class="fa-solid fa-user"></i> Guest details</h2>
                            <div class="bk_fact_label">Name</div>
                            <div class="bk_fact_value mb-3">{{ $guestName ?: '—' }}</div>
                            <div class="bk_fact_label">Email</div>
                            <div class="bk_fact_value mb-3">{{ $guestEmail ?: '—' }}</div>
                            @if($guestPhone)
                                <div class="bk_fact_label">Phone</div>
                                <div class="bk_fact_value mb-3">{{ $guestPhone }}</div>
                            @endif
                            @if($address)
                                <div class="bk_fact_label">Address</div>
                                <div class="bk_fact_value mb-3">{{ $address }}</div>
                            @endif
                            @if($order->guest_vehicle_number)
                                <div class="bk_fact_label">Vehicle</div>
                                <div class="bk_fact_value">{{ $order->guest_vehicle_number }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="bk_card">
                            <h2 class="bk_card_title"><i class="fa-solid fa-receipt"></i> Payment summary</h2>
                            <div class="bk_total_row"><span>Subtotal</span><span>{{ $currency }} {{ number_format($order->subtotal, 2) }}</span></div>
                            @if($order->pet_fee_total > 0)
                                <div class="bk_total_row"><span>Pet fee</span><span>{{ $currency }} {{ number_format($order->pet_fee_total, 2) }}</span></div>
                            @endif
                            @if($order->laundry_fee_total > 0)
                                <div class="bk_total_row"><span>Laundry</span><span>{{ $currency }} {{ number_format($order->laundry_fee_total, 2) }}</span></div>
                            @endif
                            <div class="bk_total_row"><span>Tax</span><span>{{ $currency }} {{ number_format($order->tax_amount, 2) }}</span></div>
                            @if($order->loyalty_discount > 0)
                                <div class="bk_total_row" style="color:#166534; font-weight:600;"><span>Loyalty discount</span><span>&minus;{{ $currency }} {{ number_format($order->loyalty_discount, 2) }}</span></div>
                            @endif
                            <div class="bk_total_row is_grand"><span>Total</span><span>{{ $currency }} {{ number_format($order->grand_total, 2) }}</span></div>
                        </div>
                    </div>
                </div>

                @if($order->stayState() === 'awaiting')
                    <div class="bk_card" id="change-dates">
                        <h2 class="bk_card_title"><i class="fa-solid fa-calendar-day"></i> Change your dates</h2>
                        @if($order->canCustomerReschedule())
                            <p class="mb-3" style="font-size:14px; color:#475569;">
                                Pick a new arrival date and your whole stay moves with it.
                                It stays <strong>{{ $nights }} {{ Str::plural('night', $nights) }}</strong>,
                                so your total remains <strong>{{ $currency }} {{ number_format($order->grand_total, 2) }}</strong>
                                and there is nothing more to pay.
                            </p>
                        @endif

                        @if(!$order->canCustomerReschedule())
                            <div class="bk_move_closed">
                                <i class="fa-solid fa-lock"></i>
                                <div>
                                    <strong>Dates can no longer be changed online.</strong>
                                    Your arrival is less than 24 hours away &mdash; the cut-off was
                                    {{ $order->rescheduleDeadline()?->format('F d, Y') }}.
                                    Give us a call and we will do what we can.
                                </div>
                            </div>
                        @else
                        <form method="POST" action="{{ route('customer.booking.reschedule', $order->order_number) }}"
                              class="bk_move_form" id="reschedule-form">
                            @csrf
                            <div>
                                <label for="new_check_in" class="bk_fact_label">New arrival date</label>
                                @php
                                    // A stay can still be waiting for its guest after its own arrival
                                    // date has gone by, and the picker will not accept a past date, so
                                    // fall forward to today rather than leaving the box empty.
                                    $suggested = $firstIn ? \Carbon\Carbon::parse($firstIn)->startOfDay() : now()->startOfDay();
                                    if ($suggested->isPast()) $suggested = now()->startOfDay();
                                @endphp
                                <input type="text" name="check_in" id="new_check_in" autocomplete="off"
                                       value="{{ old('check_in', $suggested->toDateString()) }}"
                                       class="form-control @error('check_in') is-invalid @enderror"
                                       style="border-radius:10px; min-width:210px;" required>
                                @error('check_in')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <span class="bk_fact_label">New departure</span>
                                <div class="bk_derived" id="new_check_out_display">&mdash;</div>
                            </div>
                            <button type="button" class="bk_btn_move" id="move-open">
                                <i class="fa-solid fa-arrow-right-arrow-left"></i> Move booking
                            </button>
                            <p class="bk_move_msg" id="move-msg"></p>
                        </form>

                        <p class="bk_policy">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Dates that are already full are greyed out. If the room is taken on the dates you want,
                            we will tell you and nothing will change.
                            @if($order->rescheduleDeadline())
                                You can change these dates until
                                <strong>{{ $order->rescheduleDeadline()->format('F d, Y') }}</strong>,
                                which is 24 hours before you arrive.
                            @endif
                        </p>
                        @endif
                    </div>

                    <div class="modal fade" id="moveBookingModal" tabindex="-1" aria-labelledby="moveBookingLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius:16px; border:0;">
                                <div class="modal-header" style="border-bottom:1px solid #EEF2F7;">
                                    <h5 class="modal-title" id="moveBookingLabel" style="font-weight:800; color:#0F172A;">
                                        Move this booking?
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="bk_move_compare">
                                        <div>
                                            <div class="bk_fact_label">Currently</div>
                                            <div class="bk_move_dates">
                                                {{ $firstIn ? \Carbon\Carbon::parse($firstIn)->format('M d') : '' }}
                                                &rarr;
                                                {{ $lastOut ? \Carbon\Carbon::parse($lastOut)->format('M d, Y') : '' }}
                                            </div>
                                        </div>
                                        <i class="fa-solid fa-arrow-right bk_move_arrow"></i>
                                        <div>
                                            <div class="bk_fact_label">Moving to</div>
                                            <div class="bk_move_dates" id="confirm-dates">&mdash;</div>
                                        </div>
                                    </div>
                                    <p class="mb-0" style="font-size:14px; color:#475569;">
                                        Still {{ $nights }} {{ Str::plural('night', $nights) }} and still
                                        {{ $currency }} {{ number_format($order->grand_total, 2) }} &mdash; nothing more to pay.
                                    </p>
                                </div>
                                <div class="modal-footer" style="border-top:1px solid #EEF2F7;">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:30px; padding:10px 22px; font-weight:600;">
                                        Keep my dates
                                    </button>
                                    <button type="submit" form="reschedule-form" class="bk_btn_move">
                                        <i class="fa-solid fa-check"></i> Yes, move it
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($order->canCustomerCancel())
                    <div class="bk_card" id="cancel">
                        <h2 class="bk_card_title"><i class="fa-solid fa-ban"></i> Cancel this booking</h2>
                        <p class="mb-3" style="font-size:14px; color:#475569;">
                            Changed your plans? You can cancel this booking until you check in.
                        </p>
                        <button type="button" class="bk_btn_danger" data-bs-toggle="modal" data-bs-target="#cancelBookingModal">
                            <i class="fa-solid fa-circle-xmark"></i> Cancel booking
                        </button>
                        @if($order->payment_status === 'paid')
                            <p class="bk_policy">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                This booking is paid. Once cancelled, our team will contact you about your refund.
                            </p>
                        @endif
                    </div>

                    <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form method="POST" action="{{ route('customer.booking.cancel', $order->order_number) }}" class="modal-content" style="border-radius:16px; border:0;">
                                @csrf
                                <div class="modal-header" style="border-bottom:1px solid #EEF2F7;">
                                    <h5 class="modal-title" id="cancelBookingLabel" style="font-weight:800; color:#0F172A;">
                                        Cancel booking #{{ $order->order_number }}?
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p style="font-size:14px; color:#475569;">
                                        This releases your {{ $order->roomCount() }} {{ Str::plural('room', $order->roomCount()) }}
                                        for {{ $firstIn ? \Carbon\Carbon::parse($firstIn)->format('M d') : '' }}
                                        &ndash; {{ $lastOut ? \Carbon\Carbon::parse($lastOut)->format('M d, Y') : '' }}. This cannot be undone.
                                    </p>
                                    <label for="cancellation_reason" class="form-label" style="font-weight:700; font-size:13px; color:#0F172A;">
                                        Why are you cancelling? <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        name="cancellation_reason"
                                        id="cancellation_reason"
                                        rows="3"
                                        required
                                        minlength="5"
                                        maxlength="1000"
                                        class="form-control @error('cancellation_reason') is-invalid @enderror"
                                        style="border-radius:10px;"
                                        placeholder="e.g. My travel dates have changed"></textarea>
                                    @error('cancellation_reason')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="modal-footer" style="border-top:1px solid #EEF2F7;">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:30px; padding:10px 22px; font-weight:600;">
                                        Keep booking
                                    </button>
                                    <button type="submit" class="bk_btn_danger">
                                        <i class="fa-solid fa-circle-xmark"></i> Cancel booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>

@if($order->canCustomerReschedule())
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('new_check_in');
    var out = document.getElementById('new_check_out_display');
    var NIGHTS = {{ $nights }};

    // Same per-night counts the booking page shows, so a guest is not offered
    // an arrival date the rooms cannot actually take.
    var mvCalendar = {};

    function key(d) {
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0')
            + '-' + String(d.getDate()).padStart(2, '0');
    }
    function isFull(d) {
        var info = mvCalendar[key(d)];
        return !!(info && info.full);
    }
    function decorate(dayElem) {
        var info = mvCalendar[key(dayElem.dateObj)];
        if (!info) return;
        var old = dayElem.querySelector('.mv-day-left');
        if (old) old.remove();
        var tag = document.createElement('span');
        tag.className = 'mv-day-left' + (info.full ? ' is_full' : '');
        tag.textContent = info.full ? 'Full' : info.free;
        dayElem.appendChild(tag);
    }

    function showDeparture(dates) {
        if (!dates.length) { out.textContent = '\u2014'; return; }
        var d = new Date(dates[0]);
        d.setDate(d.getDate() + NIGHTS);
        out.textContent = d.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
    }

    var picker = flatpickr(input, {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'M j, Y',
        // The server decides what counts as today, so the picker uses its date
        // rather than the browser's: otherwise a guest an hour ahead of the
        // server sees their own arrival date rejected as being in the past.
        minDate: '{{ now()->toDateString() }}',
        disable: [isFull],
        onDayCreate: function (dObj, dStr, fp, dayElem) { decorate(dayElem); },
        onChange: function (dates) {
            showDeparture(dates);
            msg.textContent = '';
        }
    });

    showDeparture(picker.selectedDates);

    // The dialog restates the dates the guest actually picked, so a mis-click
    // on the calendar is caught before anything moves.
    var openBtn = document.getElementById('move-open');
    var confirmDates = document.getElementById('confirm-dates');

    var msg = document.getElementById('move-msg');
    var CURRENT_ARRIVAL = @json($firstIn ? \Carbon\Carbon::parse($firstIn)->toDateString() : '');

    openBtn.addEventListener('click', function () {
        if (!picker.selectedDates.length) { picker.open(); return; }

        // Confirming a move to the date it already has helps nobody
        if (input.value === CURRENT_ARRIVAL) {
            msg.textContent = 'That is already your arrival date. Pick a different one to move this booking.';
            picker.open();
            return;
        }

        confirmDates.textContent = picker.altInput.value + '  \u2192  ' + out.textContent;
        new bootstrap.Modal(document.getElementById('moveBookingModal')).show();
    });

    fetch('{{ route("room.availability.calendar") }}')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            mvCalendar = (data && data.dates) || {};
            picker.redraw();
        })
        .catch(function () { /* the picker still works, just without counts */ });
});
</script>
@endif

@if($errors->has('cancellation_reason'))
    {{-- Reopen the dialog so the guest sees why their reason was rejected --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('cancelBookingModal');
            if (modal && window.bootstrap) new bootstrap.Modal(modal).show();
        });
    </script>
@endif

{{-- 
    The page sits inside GSAP ScrollSmoother's #smooth-content, which carries a
    transform. A transformed ancestor becomes the containing block for
    position:fixed and starts its own stacking context, so a Bootstrap modal
    left inside it lands in the wrong place and sits under its own backdrop.
    Re-parenting the dialogs to <body> puts them back on the viewport.
--}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    ['moveBookingModal', 'cancelBookingModal'].forEach(function (id) {
        var modal = document.getElementById(id);
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    });
});
</script>

@include('front.inc.footer')
