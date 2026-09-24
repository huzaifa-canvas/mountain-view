@include('admin.inc.header', ['pageTitle' => 'Guest Feedback'])

@php
  $categories = [
    'Room Cleanliness',
    'Staff Service',
    'Amenities',
    'Food & Beverages',
    'Check-in / Check-out Process',
    'Value for Money',
    'General Suggestion',
    'Complaint',
    'Other',
  ];
  $hasFilters = request('search') || request('category');
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>Guest Feedback</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Feedback</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to orders
      </a>
    </div>
  </div>

  <section class="section">

    <div class="mv-chips mb-3">
      <span class="mv-chip"><i class="bi bi-chat-square-text"></i> {{ number_format($feedbacks->total()) }} {{ $hasFilters ? 'matching' : 'total' }} {{ Str::plural('entry', $feedbacks->total()) }}</span>
      @if($hasFilters)
        <a href="{{ route('admin.feedbacks.index') }}" class="mv-chip"><i class="bi bi-x-circle"></i> Clear filters</a>
      @endif
    </div>

    <form method="GET" action="{{ route('admin.feedbacks.index') }}" class="mv-filters">
      <div class="row g-3 align-items-end">
        <div class="col-lg-5 col-md-6">
          <label class="form-label" for="fb-search">Search</label>
          <input type="search" id="fb-search" name="search" class="form-control" placeholder="Name, email or order #…" value="{{ request('search') }}">
        </div>
        <div class="col-lg-4 col-md-6">
          <label class="form-label" for="fb-category">Category</label>
          <select id="fb-category" name="category" class="form-select">
            <option value="">All categories</option>
            @foreach($categories as $cat)
              <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-lg-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-funnel me-1"></i> Filter</button>
          <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
        </div>
      </div>
    </form>

    <div class="mv-table-wrap">
      <div class="table-responsive">
        <table class="table mv-responsive-table align-middle">
          <thead>
            <tr>
              <th>Guest</th>
              <th>Order</th>
              <th>Category</th>
              <th>Message</th>
              <th>Follow-up</th>
              <th>Received</th>
            </tr>
          </thead>
          <tbody>
            @forelse($feedbacks as $fb)
              @php
                $badgeClass = [
                  'Complaint'          => 'bg-danger',
                  'Room Cleanliness'   => 'bg-warning',
                  'Staff Service'      => 'bg-info',
                  'General Suggestion' => 'bg-secondary',
                ][$fb->category] ?? 'bg-secondary';
              @endphp
              <tr>
                <td data-label="Guest" class="mv-cell-block">
                  <span class="mv-cell-strong">{{ $fb->guest_name ?: 'Guest' }}</span>
                  <div class="mv-cell-sub">{{ $fb->guest_email }}</div>
                </td>

                <td data-label="Order">
                  @if($fb->order_id)
                    <a href="{{ route('admin.orders.show', $fb->order_id) }}" class="mv-cell-strong">#{{ $fb->order_number }}</a>
                  @else
                    <span class="text-muted">#{{ $fb->order_number }}</span>
                  @endif
                </td>

                <td data-label="Category"><span class="badge {{ $badgeClass }}">{{ $fb->category }}</span></td>

                <td data-label="Message" class="mv-cell-block" style="max-width:340px;">
                  <p class="mb-2" style="font-size:.86rem;color:var(--mv-text-2);">{{ Str::limit($fb->message, 140) }}</p>
                  @if($fb->screenshot_path)
                    <a href="{{ asset($fb->screenshot_path) }}" target="_blank" rel="noopener" class="mv-fact">
                      <i class="bi bi-paperclip"></i> Attachment
                    </a>
                  @endif
                </td>

                <td data-label="Follow-up">
                  @if($fb->contact_me)
                    <span class="badge bg-success"><i class="bi bi-telephone me-1"></i> Requested</span>
                  @else
                    <span class="mv-cell-sub">Not requested</span>
                  @endif
                </td>

                <td data-label="Received">
                  <span class="mv-cell-strong">{{ $fb->created_at?->format('M d, Y') }}</span>
                  <div class="mv-cell-sub">{{ $fb->created_at?->format('g:i A') }}</div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="mv-empty">
                    <i class="bi bi-chat-square-text"></i>
                    {{ $hasFilters ? 'No feedback matches these filters.' : 'No guest feedback received yet.' }}
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($feedbacks->hasPages())
      <div class="d-flex justify-content-center mt-4">
        {{ $feedbacks->appends(request()->query())->links() }}
      </div>
    @endif

  </section>

</main>

@include('admin.inc.footer')
