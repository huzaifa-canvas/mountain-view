@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Guest Feedbacks</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Feedbacks</li>
        </ol>
      </nav>
    </div>
    <div>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Back to Orders</a>
    </div>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Feedback Submissions</h5>

            <form method="GET" action="{{ route('admin.feedbacks.index') }}" class="row g-2 mb-4 align-items-end">
              <div class="col-md-4 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, Email, Order #..." value="{{ request('search') }}">
              </div>
              <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-bold text-muted mb-1">Category</label>
                <select name="category" class="form-select">
                  <option value="">All Categories</option>
                  <option value="Room Cleanliness" {{ request('category') == 'Room Cleanliness' ? 'selected' : '' }}>Room Cleanliness</option>
                  <option value="Staff Service" {{ request('category') == 'Staff Service' ? 'selected' : '' }}>Staff Service</option>
                  <option value="Amenities" {{ request('category') == 'Amenities' ? 'selected' : '' }}>Amenities</option>
                  <option value="Food & Beverages" {{ request('category') == 'Food & Beverages' ? 'selected' : '' }}>Food & Beverages</option>
                  <option value="Check-in / Check-out Process" {{ request('category') == 'Check-in / Check-out Process' ? 'selected' : '' }}>Check-in / Check-out</option>
                  <option value="Value for Money" {{ request('category') == 'Value for Money' ? 'selected' : '' }}>Value for Money</option>
                  <option value="General Suggestion" {{ request('category') == 'General Suggestion' ? 'selected' : '' }}>General Suggestion</option>
                  <option value="Complaint" {{ request('category') == 'Complaint' ? 'selected' : '' }}>Complaint</option>
                  <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel me-1"></i> Filter</button>
              </div>
              <div class="col-md-2">
                <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-x-circle me-1"></i> Clear</a>
              </div>
            </form>

            @if($feedbacks->count() > 0)
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Order #</th>
                    <th>Category</th>
                    <th>Message</th>
                    <th>Contact?</th>
                    <th>Attachment</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($feedbacks as $fb)
                  <tr>
                    <td>{{ $fb->id }}</td>
                    <td>
                      <strong>{{ $fb->guest_name }}</strong><br>
                      <small class="text-muted">{{ $fb->guest_email }}</small>
                    </td>
                    <td>
                      @if($fb->order_id)
                        <a href="{{ route('admin.orders.show', $fb->order_id) }}"><strong>#{{ $fb->order_number }}</strong></a>
                      @else
                        <span class="text-muted">#{{ $fb->order_number }}</span>
                      @endif
                    </td>
                    <td>
                      @php
                        $catColors = [
                          'Complaint' => 'bg-danger',
                          'Room Cleanliness' => 'bg-warning text-dark',
                          'Staff Service' => 'bg-info text-dark',
                          'General Suggestion' => 'bg-primary',
                        ];
                        $badgeClass = $catColors[$fb->category] ?? 'bg-secondary';
                      @endphp
                      <span class="badge {{ $badgeClass }}">{{ $fb->category }}</span>
                    </td>
                    <td style="max-width:300px;">
                      <p class="mb-0 text-truncate" title="{{ $fb->message }}">{{ Str::limit($fb->message, 80) }}</p>
                    </td>
                    <td>
                      @if($fb->contact_me)
                        <span class="badge bg-success"><i class="bi bi-telephone me-1"></i> Yes</span>
                      @else
                        <span class="text-muted small">No</span>
                      @endif
                    </td>
                    <td>
                      @if($fb->screenshot_path)
                        <a href="{{ asset($fb->screenshot_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                          <i class="bi bi-file-earmark-image"></i> View
                        </a>
                      @else
                        <span class="text-muted small">—</span>
                      @endif
                    </td>
                    <td><small>{{ $fb->created_at->format('M d, Y') }}<br>{{ $fb->created_at->format('g:i A') }}</small></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="mt-3">
              {{ $feedbacks->appends(request()->query())->links() }}
            </div>

            @else
              <div class="text-center py-5">
                <i class="bi bi-chat-square-text" style="font-size:48px; color:#cbd5e1;"></i>
                <p class="text-muted mt-3">No feedback submissions found.</p>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>

</main>

@include('admin.inc.footer')
