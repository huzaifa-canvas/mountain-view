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

@if($errors->has('cancellation_reason'))
    {{-- Reopen the dialog so the guest sees why their reason was rejected --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('cancelBookingModal');
            if (modal && window.bootstrap) new bootstrap.Modal(modal).show();
        });
    </script>
@endif

@include('front.inc.footer')
