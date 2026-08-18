@include('front.inc.header')

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">MY ACCOUNT</h6>
        </div> 
    </div>
</section>

<style>
    .checkout_wrapper {
        padding: 75px 0px;
        background-color: #F5F7FC;
    }

    #v-pills-tabContent {
        width: 100%;
    }   
</style>

<section class="checkout_wrapper">
    <div class="container">
        <div class="checkout_m_wrap_old" style="width: 100%;">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 mb-4 mb-md-0">
                    <div class="bg-white p-4 rounded-3 shadow-sm border">
                        <h5 class="mb-4 text-dark fw-bold">Hello, {{ $customer->first_name }}</h5>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active w-100 text-start mb-2 py-2 px-3 fw-semibold" id="v-pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab"><i class="fa-solid fa-gauge me-2"></i> Dashboard</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 text-start mb-2 py-2 px-3 fw-semibold" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" type="button" role="tab"><i class="fa-solid fa-receipt me-2"></i> Order History</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 text-start mb-2 py-2 px-3 fw-semibold" id="v-pills-loyalty-tab" data-bs-toggle="pill" data-bs-target="#v-pills-loyalty" type="button" role="tab"><i class="fa-solid fa-coins me-2"></i> Loyalty Points</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 text-start mb-2 py-2 px-3 fw-semibold" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab"><i class="fa-solid fa-user-pen me-2"></i> Profile Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link w-100 text-start text-danger py-2 px-3 fw-semibold mt-3" href="{{ route('customer.logout') }}"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        
                        <!-- Dashboard Tab -->
                        <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel">
                            <div class="bg-white p-4 rounded-3 shadow-sm border">
                                <h4 class="profile-card-title"><i class="fa-solid fa-gauge"></i> Overview</h4>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card shadow-sm border h-100 bg-light">
                                            <div class="card-body p-4">
                                                <h6 class="text-muted fw-semibold">Available Loyalty Points</h6>
                                                <h2 class="display-6 fw-bold mb-1" style="color: #184E77">{{ number_format($customer->loyalty_points, 0) }}</h2>
                                                <p class="text-success fw-bold mb-0">Value: {{ $currency }} {{ number_format($points_value, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="card shadow-sm border h-100 bg-light">
                                            <div class="card-body p-4">
                                                <h6 class="text-muted fw-semibold">Total Bookings</h6>
                                                <h2 class="display-6 fw-bold mb-0 text-dark">{{ count($orders) }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="fw-bold mt-4 mb-3" style="font-size: 16px; color: #1e293b;"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Recent Bookings</h5>
                                @if(count($orders) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders->take(5) as $order)
                                                <tr>
                                                    <td><strong>#{{ $order->order_number }}</strong></td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($order->payment_status == 'paid')
                                                            <span class="badge bg-success">Paid</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">{{ ucfirst($order->payment_status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td><strong>{{ $currency }} {{ number_format($order->grand_total, 2) }}</strong></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">You don't have any bookings yet.</p>
                                    <a href="{{ url('room') }}" class="common_dark_btn">Book a Room</a>
                                @endif
                            </div>
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="v-pills-orders" role="tabpanel">
                            <div class="bg-white p-4 rounded-3 shadow-sm border">
                                <h4 class="profile-card-title"><i class="fa-solid fa-receipt"></i> Order History</h4>
                                
                                @if(count($orders) > 0)
                                    @foreach($orders as $order)
                                        <div class="card mb-4 shadow-sm border">
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                                                <h6 class="mb-0 fw-bold">Order #{{ $order->order_number }}</h6>
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
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">You don't have any order history yet.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Loyalty Tab -->
                        <div class="tab-pane fade" id="v-pills-loyalty" role="tabpanel">
                            <div class="bg-white p-4 rounded-3 shadow-sm border">
                                <h4 class="profile-card-title"><i class="fa-solid fa-coins"></i> Loyalty Points</h4>
                                
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body text-center p-5">
                                        <h5 class="text-muted mb-2">Your Points Balance</h5>
                                        <h1 class="display-3 fw-bold mb-2" style="color: #184E77">{{ number_format($customer->loyalty_points, 0) }}</h1>
                                        <h4 class="text-success fw-bold">= {{ $currency }} {{ number_format($points_value, 2) }}</h4>
                                        <p class="mt-3 text-muted mb-0">Points can be applied as a discount during checkout.</p>
                                    </div>
                                </div>
                                
                                <h5 class="fw-bold mt-4 mb-3" style="font-size: 16px; color: #1e293b;"><i class="fa-solid fa-list-check text-primary me-2"></i> Recent Transactions</h5>
                                @php
                                    $transactions = $customer->loyaltyTransactions()->orderBy('created_at', 'desc')->get();
                                @endphp
                                
                                @if(count($transactions) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions as $trans)
                                                <tr>
                                                    <td>{{ $trans->created_at->format('M d, Y') }}</td>
                                                    <td>{{ $trans->description }}</td>
                                                    <td>
                                                        @if($trans->type == 'earned')
                                                            <span class="text-success fw-bold">+{{ number_format($trans->points, 0) }}</span>
                                                        @else
                                                            <span class="text-danger fw-bold">-{{ number_format($trans->points, 0) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No loyalty transactions found.</p>
                                @endif
                            </div>
                        </div>

<style>
    .profile-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .profile-card-title i {
        font-size: 20px;
        color: #184E77;
    }
    .profile-form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .profile-form-control {
        height: 46px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 0 16px;
        font-size: 14px;
        color: #1e293b;
        background-color: #ffffff;
        transition: all 0.2s ease-in-out;
    }
    .profile-form-control:focus {
        border-color: #184E77;
        box-shadow: 0 0 0 3px rgba(24, 78, 119, 0.15);
    }
    .profile-submit-btn {
        background-color: #184E77;
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(24, 78, 119, 0.2);
    }
    .profile-submit-btn:hover {
        background-color: #123957;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(24, 78, 119, 0.3);
    }
</style>

                        <!-- Profile Settings Tab -->
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel">
                            <div class="bg-white p-4 rounded-3 shadow-sm border mb-4">
                                <h4 class="profile-card-title"><i class="fa-solid fa-user-gear"></i> Personal Information</h4>

                                @if(session('success'))
                                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger mb-4">
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

                            <!-- Change Password Section (Separate Card at Bottom) -->
                            <div class="bg-white p-4 rounded-3 shadow-sm border">
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
