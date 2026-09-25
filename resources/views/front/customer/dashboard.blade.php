@include('front.inc.header')

@php
    // One place decides how a stay is coloured, so the overview table, the
    // history cards and the details page never disagree.
    $stayTone = function ($order) {
        return match ($order->stayState()) {
            'cancelled'   => ['bg' => '#FEE2E2', 'fg' => '#991B1B', 'icon' => 'fa-circle-xmark'],
            'checked_out' => ['bg' => '#E2E8F0', 'fg' => '#334155', 'icon' => 'fa-circle-check'],
            'checked_in'  => ['bg' => '#DCFCE7', 'fg' => '#166534', 'icon' => 'fa-house-user'],
            'no_show'     => ['bg' => '#FEF3C7', 'fg' => '#92400E', 'icon' => 'fa-user-slash'],
            default       => ['bg' => '#DBEAFE', 'fg' => '#1E40AF', 'icon' => 'fa-clock'],
        };
    };
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .stat_box_label {
        font-size: 12px; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: .6px; margin-bottom: 6px;
    }
    .stat_box_value {
        font-size: 30px; font-weight: 800; margin-bottom: 4px;
        font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.1;
    }
    .stat_box_icon {
        background: #ffffff; width: 42px; height: 42px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #184E77; font-size: 18px; flex: 0 0 auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05);
    }
    .mini_stat_label i { margin-right: 5px; opacity: .8; }
    .pay_badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 30px;
        font-size: 12px; font-weight: 700; white-space: nowrap;
    }
    .pay_badge_paid { background: #DCFCE7; color: #166534; }
    .pay_badge_due  { background: #FEF3C7; color: #92400E; }
    .points_summary {
        display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px;
    }
    .points_summary_item {
        flex: 1 1 150px; background: #fff; border: 1px solid #e2e8f0;
        border-radius: 12px; padding: 13px 16px;
    }
    .points_summary_label {
        font-size: 11px; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .6px; margin-bottom: 4px;
    }
    .points_summary_value { font-size: 19px; font-weight: 800; }
    .txn_order_link { color: #184E77; font-weight: 700; text-decoration: none; }
    .txn_order_link:hover { text-decoration: underline; }
    .member_since {
        font-size: 12px; color: #64748b; font-weight: 600;
        margin: 6px 0 0; display: flex; align-items: center; gap: 6px;
    }
    .stay_badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 13px; border-radius: 30px;
        font-size: 12px; font-weight: 700; white-space: nowrap;
    }
    .next_stay_card {
        background: linear-gradient(135deg, #184E77 0%, #1F6394 100%);
        border-radius: 16px; padding: 22px 24px; color: #fff; margin-bottom: 20px;
    }
    .next_stay_label {
        font-size: 11px; font-weight: 700; letter-spacing: .8px;
        text-transform: uppercase; opacity: .75; margin-bottom: 6px;
    }
    .next_stay_dates { font-size: 21px; font-weight: 800; margin-bottom: 4px; }
    .next_stay_meta { font-size: 13px; opacity: .85; }
    .next_stay_btn {
        background: #fff; color: #184E77; font-weight: 700; font-size: 13px;
        border-radius: 30px; padding: 9px 20px; text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px; white-space: nowrap;
    }
    .next_stay_btn:hover { background: #E2E8F0; color: #123A59; }
    .mini_stat {
        background: #fff; border: 1px solid #E2E8F0; border-radius: 14px;
        padding: 16px 18px; height: 100%;
    }
    .mini_stat_label {
        font-size: 11px; font-weight: 700; color: #94A3B8;
        text-transform: uppercase; letter-spacing: .7px; margin-bottom: 6px;
    }
    .mini_stat_value { font-size: 22px; font-weight: 800; color: #0F172A; line-height: 1.1; }
    .order_card_actions { display: flex; flex-wrap: wrap; gap: 9px; }
    .btn_pill_outline {
        border: 1px solid #CBD5E1; background: #fff; color: #0F172A;
        font-weight: 700; font-size: 13px; border-radius: 30px;
        padding: 9px 20px; text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
    }
    .btn_pill_outline:hover { border-color: #184E77; color: #184E77; }
    .btn_pill_danger {
        border: 1px solid #FCA5A5; background: #fff; color: #DC2626;
        font-weight: 700; font-size: 13px; border-radius: 30px;
        padding: 9px 20px; text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
    }
    .btn_pill_danger:hover { background: #DC2626; border-color: #DC2626; color: #fff; }
    .cancel_reason_note {
        background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px;
        padding: 11px 14px; color: #7F1D1D; font-size: 13px; margin-top: 12px;
    }
    .checkout_wrapper {
        padding: 65px 0px 90px;
        background-color: #F8FAFC;
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    }

    #v-pills-tabContent {
        width: 100%;
    }

    /* Customer Sidebar Styling */
    .dash_sidebar_card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05);
    }
    .dash_user_header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1.5px solid #f1f5f9;
    }
    .dash_user_avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #184E77 0%, #1e293b 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        box-shadow: 0 4px 12px rgba(24, 78, 119, 0.25);
    }
    .dash_user_title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }
    .dash_user_sub {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .dash_nav_link {
        width: 100%;
        text-align: left;
        padding: 12px 16px !important;
        margin-bottom: 8px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        border-radius: 12px !important;
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        transition: all 0.25s ease !important;
    }
    .dash_nav_link i {
        font-size: 16px;
        width: 20px;
        text-align: center;
        color: #184E77;
        transition: all 0.25s ease;
    }
    .dash_nav_link:hover {
        background: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
    }
    .dash_nav_link.active {
        background: #184E77 !important;
        border-color: #184E77 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 6px 18px rgba(24, 78, 119, 0.25) !important;
    }
    .dash_nav_link.active i {
        color: #ffffff !important;
    }

    .dash_logout_link {
        width: 100%;
        text-align: left;
        padding: 12px 16px;
        margin-top: 16px;
        font-size: 14px;
        font-weight: 700;
        color: #ef4444;
        border-radius: 12px;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .dash_logout_link:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    /* Main Dashboard Cards */
    .dash_main_card {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05);
    }
    .profile-card-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .profile-card-title i {
        font-size: 20px;
        color: #184E77;
    }

    /* Stat Cards */
    .stat_box_card {
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid #e2e8f0;
        height: 100%;
        transition: all 0.25s ease;
    }
    .stat_box_card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
    }
    .stat_box_loyalty {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-color: #bae6fd;
    }
    .stat_box_bookings {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-color: #e2e8f0;
    }

    /* Forms */
    .profile-form-label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .profile-form-control {
        height: 48px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        padding: 0 16px;
        font-size: 14px;
        color: #0f172a;
        background-color: #f8fafc;
        transition: all 0.25s ease-in-out;
    }
    .profile-form-control:focus {
        border-color: #184E77;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(24, 78, 119, 0.12);
    }
    .profile-submit-btn {
        background-color: #184E77;
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(24, 78, 119, 0.25);
    }
    .profile-submit-btn:hover {
        background-color: #123957;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(24, 78, 119, 0.35);
    }

    /* Empty state */
    .empty_bookings_box {
        text-align: center;
        padding: 40px 20px;
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 14px;
        margin-top: 12px;
    }
</style>

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">MY ACCOUNT</h6>
        </div> 
    </div>
</section>

<section class="checkout_wrapper">
    <div class="container">
        <div class="checkout_m_wrap_old" style="width: 100%;">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-12 col-md-4 col-lg-3 mb-4 mb-md-0">
                    <div class="dash_sidebar_card">
                        <div class="dash_user_header">
                            <div class="dash_user_avatar">
                                {{ strtoupper(substr($customer->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="dash_user_title">Hello, {{ $customer->first_name }}</h5>
                                <p class="dash_user_sub">{{ $customer->email }}</p>
                                <p class="member_since">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    Member since {{ $customer->created_at->format('M Y') }}
                                </p>
                            </div>
                        </div>

                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link dash_nav_link active" id="v-pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab"><i class="fa-solid fa-chart-line"></i> Dashboard</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link dash_nav_link" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" type="button" role="tab"><i class="fa-solid fa-receipt"></i> Order History</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link dash_nav_link" id="v-pills-loyalty-tab" data-bs-toggle="pill" data-bs-target="#v-pills-loyalty" type="button" role="tab"><i class="fa-solid fa-coins"></i> Loyalty Points</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link dash_nav_link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab"><i class="fa-solid fa-user-gear"></i> Profile Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="dash_logout_link" href="{{ route('customer.logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        
                        <!-- Dashboard Tab -->
                        <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel">
                            <div class="dash_main_card">
                                <h4 class="profile-card-title"><i class="fa-solid fa-chart-line"></i> Overview</h4>

                                @if($nextStay)
                                    @php
                                        $nsIn  = $nextStay->items->min('check_in');
                                        $nsOut = $nextStay->items->max('check_out');
                                    @endphp
                                    <div class="next_stay_card">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                            <div>
                                                <div class="next_stay_label"><i class="fa-solid fa-suitcase-rolling me-1"></i> Your next stay</div>
                                                <div class="next_stay_dates">
                                                    {{ $nsIn ? \Carbon\Carbon::parse($nsIn)->format('M d') : '' }}
                                                    &rarr;
                                                    {{ $nsOut ? \Carbon\Carbon::parse($nsOut)->format('M d, Y') : '' }}
                                                </div>
                                                <div class="next_stay_meta">
                                                    #{{ $nextStay->order_number }}
                                                    &middot; {{ $nextStay->roomCount() }} {{ Str::plural('room', $nextStay->roomCount()) }}
                                                    &middot; {{ $nextStay->stayLabel() }}
                                                    @if($nsIn && \Carbon\Carbon::parse($nsIn)->isFuture())
                                                        @php $daysAway = (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($nsIn)->startOfDay()); @endphp
                                                        &middot; in {{ $daysAway }} {{ Str::plural('day', $daysAway) }}
                                                    @endif
                                                </div>
                                            </div>
                                            <a href="{{ route('customer.booking.show', $nextStay->order_number) }}" class="next_stay_btn">
                                                View booking <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="stat_box_card stat_box_loyalty">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="stat_box_label">Available Loyalty Points</h6>
                                                    <h2 class="stat_box_value" style="color:#184E77;">{{ number_format($customer->loyalty_points, 0) }}</h2>
                                                    <p class="text-success fw-bold mb-0" style="font-size:14px;"><i class="fa-solid fa-tags me-1"></i> Worth {{ $currency }} {{ number_format($points_value, 2) }}</p>
                                                </div>
                                                <div class="stat_box_icon"><i class="fa-solid fa-coins"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="stat_box_card stat_box_bookings">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="stat_box_label">Total Spent</h6>
                                                    <h2 class="stat_box_value text-dark">{{ $currency }} {{ number_format($stats['total_spent'], 2) }}</h2>
                                                    <p class="mb-0" style="font-size:14px; color:#64748b; font-weight:600;">
                                                        across {{ $stats['bookings'] }} {{ Str::plural('booking', $stats['bookings']) }}
                                                    </p>
                                                </div>
                                                <div class="stat_box_icon"><i class="fa-solid fa-wallet"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mt-1">
                                    <div class="col-6 col-lg-3">
                                        <div class="mini_stat">
                                            <div class="mini_stat_label"><i class="fa-solid fa-suitcase-rolling"></i> Upcoming</div>
                                            <div class="mini_stat_value">{{ $stats['upcoming'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="mini_stat">
                                            <div class="mini_stat_label"><i class="fa-solid fa-circle-check"></i> Completed</div>
                                            <div class="mini_stat_value">{{ $stats['completed'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="mini_stat">
                                            <div class="mini_stat_label"><i class="fa-solid fa-moon"></i> Nights booked</div>
                                            <div class="mini_stat_value">{{ $stats['nights'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="mini_stat">
                                            <div class="mini_stat_label"><i class="fa-solid fa-receipt"></i> All bookings</div>
                                            <div class="mini_stat_value">{{ $stats['bookings'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="fw-bold mt-4 mb-3" style="font-size: 16px; color: #0f172a;"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Recent Bookings</h5>
                                @if(count($orders) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Stay</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders->take(5) as $order)
                                                @php $tone = $stayTone($order); @endphp
                                                <tr>
                                                    <td>
                                                        <strong>#{{ $order->order_number }}</strong>
                                                        <div class="text-muted" style="font-size:12px;">{{ $order->created_at->format('M d, Y') }}</div>
                                                    </td>
                                                    <td style="font-size:13px;">
                                                        {{ \Carbon\Carbon::parse($order->items->min('check_in'))->format('M d') }}
                                                        &rarr;
                                                        {{ \Carbon\Carbon::parse($order->items->max('check_out'))->format('M d, Y') }}
                                                        <div class="text-muted" style="font-size:12px;">
                                                            {{ $order->roomCount() }} {{ Str::plural('room', $order->roomCount()) }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="stay_badge" style="background: {{ $tone['bg'] }}; color: {{ $tone['fg'] }};">
                                                            <i class="fa-solid {{ $tone['icon'] }}"></i> {{ $order->stayLabel() }}
                                                        </span>
                                                        <div class="mt-1">
                                                            @if($order->payment_status == 'paid')
                                                                <span class="badge bg-success">Paid</span>
                                                            @else
                                                                <span class="badge bg-warning text-dark">{{ ucfirst($order->payment_status) }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td><strong>{{ $currency }} {{ number_format($order->grand_total, 2) }}</strong></td>
                                                    <td class="text-end">
                                                        <a href="{{ route('customer.booking.show', $order->order_number) }}" class="btn_pill_outline">
                                                            Details <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty_bookings_box">
                                        <i class="fa-regular fa-calendar-xmark" style="font-size: 38px; color: #94a3b8; margin-bottom: 12px;"></i>
                                        <p class="text-muted fw-semibold mb-3">You don't have any bookings yet.</p>
                                        <a href="{{ url('booking') }}" class="common_dark_btn" style="border-radius:30px; padding:12px 30px; font-weight:700;">
                                            <i class="fa-solid fa-calendar-plus me-2"></i> BOOK A ROOM
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="v-pills-orders" role="tabpanel">
                            <div class="dash_main_card">
                                <h4 class="profile-card-title"><i class="fa-solid fa-receipt"></i> Order History</h4>
                                
                                @if(count($orders) > 0)
                                    @foreach($orders as $order)
                                        <div class="card mb-4 shadow-sm border" style="border-radius:14px; overflow:hidden;">
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                                                <div class="d-flex flex-wrap align-items-center gap-2">
                                                    <h6 class="mb-0 fw-bold" style="color:#0f172a;">Order #{{ $order->order_number }}</h6>
                                                    @php $tone = $stayTone($order); @endphp
                                                    <span class="stay_badge" style="background: {{ $tone['bg'] }}; color: {{ $tone['fg'] }};">
                                                        <i class="fa-solid {{ $tone['icon'] }}"></i> {{ $order->stayLabel() }}
                                                    </span>
                                                    <span class="pay_badge {{ $order->payment_status === 'paid' ? 'pay_badge_paid' : 'pay_badge_due' }}">
                                                        <i class="fa-solid fa-credit-card"></i> {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </div>
                                                <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $order->created_at->format('F d, Y g:i A') }}</span>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        @foreach($order->items as $item)
                                                            <div class="d-flex mb-3 pb-2 border-bottom">
                                                                <div>
                                                                    <strong class="fs-6 text-dark">{{ $item->listing_name }}</strong> x {{ $item->rooms }} Room(s)<br>
                                                                    <small class="text-muted">
                                                                        Check-in: <strong>{{ \Carbon\Carbon::parse($item->check_in)->format('M d, Y') }}</strong> | 
                                                                        Check-out: <strong>{{ \Carbon\Carbon::parse($item->check_out)->format('M d, Y') }}</strong> ({{ $item->nights }} Night{{ $item->nights > 1 ? 's' : '' }})
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-4 text-md-end border-start">
                                                        <p class="mb-1 text-muted">Subtotal: {{ $currency }} {{ number_format($order->subtotal, 2) }}</p>
                                                        <p class="mb-1 text-muted">Tax: {{ $currency }} {{ number_format($order->tax_amount, 2) }}</p>
                                                        @if($order->loyalty_discount > 0)
                                                            <p class="mb-1 text-success fw-semibold">Discount: -{{ $currency }} {{ number_format($order->loyalty_discount, 2) }}</p>
                                                        @endif
                                                        <h5 class="mt-2 mb-0 fw-bold text-primary">Total: {{ $currency }} {{ number_format($order->grand_total, 2) }}</h5>
                                                    </div>
                                                </div>

                                                @if($order->stayState() === 'cancelled' && $order->cancellation_reason)
                                                    <div class="cancel_reason_note">
                                                        <i class="fa-solid fa-circle-xmark me-1"></i>
                                                        Cancelled{{ $order->cancelled_at ? ' on ' . \Carbon\Carbon::parse($order->cancelled_at)->format('M d, Y') : '' }}
                                                        &mdash; {{ $order->cancellation_reason }}
                                                    </div>
                                                @endif

                                                <div class="order_card_actions mt-3 pt-3" style="border-top:1px solid #EEF2F7;">
                                                    <a href="{{ route('customer.booking.show', $order->order_number) }}" class="btn_pill_outline">
                                                        <i class="fa-solid fa-eye"></i> View details
                                                    </a>
                                                    @if($order->canCustomerCancel())
                                                        <a href="{{ route('customer.booking.show', $order->order_number) }}#cancel" class="btn_pill_danger">
                                                            <i class="fa-solid fa-circle-xmark"></i> Cancel booking
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty_bookings_box">
                                        <i class="fa-solid fa-receipt" style="font-size: 38px; color: #94a3b8; margin-bottom: 12px;"></i>
                                        <p class="text-muted fw-semibold mb-3">You don't have any order history yet.</p>
                                        <a href="{{ url('booking') }}" class="common_dark_btn" style="border-radius:30px; padding:12px 30px; font-weight:700;">
                                            <i class="fa-solid fa-calendar-plus me-2"></i> BOOK A ROOM
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Loyalty Tab -->
                        <div class="tab-pane fade" id="v-pills-loyalty" role="tabpanel">
                            <div class="dash_main_card">
                                <h4 class="profile-card-title"><i class="fa-solid fa-coins"></i> Loyalty Points</h4>
                                
                                <div class="card bg-light border-0 mb-4" style="border-radius:14px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #bae6fd !important;">
                                    <div class="card-body text-center p-5">
                                        <h5 class="text-muted mb-2 fw-bold" style="font-size:14px; text-transform:uppercase; letter-spacing:0.5px;">Your Points Balance</h5>
                                        <h1 class="display-3 fw-bold mb-2" style="color: #184E77; font-family:'Plus Jakarta Sans', sans-serif;">{{ number_format($customer->loyalty_points, 0) }}</h1>
                                        <h4 class="text-success fw-bold">= {{ $currency }} {{ number_format($points_value, 2) }}</h4>
                                        <p class="mt-3 text-muted mb-0">Points can be applied as a discount during checkout.</p>
                                    </div>
                                </div>
                                
                                <div class="points_summary">
                                    <div class="points_summary_item">
                                        <div class="points_summary_label">Earned all time</div>
                                        <div class="points_summary_value text-success">+{{ number_format($points['earned']) }}</div>
                                    </div>
                                    <div class="points_summary_item">
                                        <div class="points_summary_label">Redeemed all time</div>
                                        <div class="points_summary_value text-danger">&minus;{{ number_format($points['redeemed']) }}</div>
                                    </div>
                                    <div class="points_summary_item">
                                        <div class="points_summary_label">Balance</div>
                                        <div class="points_summary_value" style="color:#184E77;">{{ number_format($customer->loyalty_points) }}</div>
                                    </div>
                                </div>

                                <h5 class="fw-bold mt-4 mb-3" style="font-size: 16px; color: #0f172a;"><i class="fa-solid fa-list-check text-primary me-2"></i> Recent Transactions</h5>

                                @if(count($transactions) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Booking</th>
                                                    <th>Reason</th>
                                                    <th class="text-end">Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions as $trans)
                                                <tr>
                                                    <td style="white-space:nowrap;">{{ $trans->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($orderNumbers->has($trans->order_id))
                                                            <a href="{{ route('customer.booking.show', $orderNumbers[$trans->order_id]) }}" class="txn_order_link">
                                                                #{{ $orderNumbers[$trans->order_id] }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">&mdash;</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $trans->type === 'earned' ? 'Earned on this stay' : 'Used as a discount' }}</td>
                                                    <td class="text-end">
                                                        @if($trans->type == 'earned')
                                                            <span class="text-success fw-bold">+{{ number_format($trans->points, 0) }}</span>
                                                        @else
                                                            <span class="text-danger fw-bold">&minus;{{ number_format($trans->points, 0) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">You have not earned any points yet. They are added automatically when a stay is paid for.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Profile Settings Tab -->
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel">
                            <div class="dash_main_card mb-4">
                                <h4 class="profile-card-title"><i class="fa-solid fa-user-gear"></i> Personal Information</h4>

                                @if(session('success'))
                                    <div class="alert alert-success mb-4" style="border-radius:10px;">{{ session('success') }}</div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger mb-4" style="border-radius:10px;">{{ session('error') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger mb-4" style="border-radius:10px;">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('customer.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="profile-form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control profile-form-control" value="{{ old('first_name', $customer->first_name) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="profile-form-label">Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control profile-form-control" value="{{ old('middle_name', $customer->middle_name) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="profile-form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control profile-form-control" value="{{ old('last_name', $customer->last_name) }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="profile-form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control profile-form-control" value="{{ old('email', $customer->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="profile-form-label">Phone Number</label>
                                            <input type="text" name="phone" class="form-control profile-form-control" value="{{ old('phone', $customer->phone) }}">
                                        </div>

                                        <div class="col-12">
                                            <label class="profile-form-label">Address</label>
                                            <input type="text" name="address" class="form-control profile-form-control" value="{{ old('address', $customer->address) }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="profile-form-label">City</label>
                                            <input type="text" name="city" class="form-control profile-form-control" value="{{ old('city', $customer->city) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="profile-form-label">State</label>
                                            <input type="text" name="state" class="form-control profile-form-control" value="{{ old('state', $customer->state) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="profile-form-label">ZIP Code</label>
                                            <input type="text" name="zip_code" class="form-control profile-form-control" value="{{ old('zip_code', $customer->zip_code) }}">
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button type="submit" class="profile-submit-btn">Update Profile <i class="fa-solid fa-check me-0 ms-1"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Change Password Section -->
                            <div class="dash_main_card">
                                <h4 class="profile-card-title"><i class="fa-solid fa-lock"></i> Change Password</h4>

                                <form action="{{ route('customer.password.update') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="profile-form-label">Current Password <span class="text-danger">*</span></label>
                                            <input type="password" name="current_password" class="form-control profile-form-control" placeholder="Enter your current password" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="profile-form-label">New Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control profile-form-control" placeholder="Minimum 8 characters" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="profile-form-label">Confirm New Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control profile-form-control" placeholder="Re-enter new password" required>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button type="submit" class="profile-submit-btn">Update Password <i class="fa-solid fa-key me-0 ms-1"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.inc.footer')
