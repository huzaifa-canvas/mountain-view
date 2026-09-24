@include('admin.inc.header', ['pageTitle' => 'Listings'])

@php
  $activeCount = $listings->where('listings_status', 1)->count();
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>Rooms &amp; Listings</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Listings</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions">
      <a href="{{ url('admin/listings/create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add New Listing
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">

    <div class="mv-chips mb-3">
      <span class="mv-chip"><i class="bi bi-collection"></i> {{ $listings->count() }} total</span>
      <span class="mv-chip"><i class="bi bi-check-circle"></i> {{ $activeCount }} active</span>
      <span class="mv-chip"><i class="bi bi-slash-circle"></i> {{ $listings->count() - $activeCount }} inactive</span>
    </div>

    <div class="mv-filters">
      <div class="row g-2 align-items-end">
        <div class="col-md-6">
          <label class="form-label" for="listingSearch">Search listings</label>
          <input type="search" id="listingSearch" class="form-control" placeholder="Type a room name…" autocomplete="off">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="listingStatus">Status</label>
          <select id="listingStatus" class="form-select">
            <option value="">All statuses</option>
            <option value="1">Active only</option>
            <option value="0">Inactive only</option>
          </select>
        </div>
        <div class="col-md-3">
          <span class="d-block form-label">&nbsp;</span>
          <span class="mv-cell-sub" id="listingCount"></span>
        </div>
      </div>
    </div>

    <div class="mv-table-wrap">
      <div class="table-responsive">
        <table class="table mv-responsive-table align-middle" id="listingsTable">
          <thead>
            <tr>
              <th style="width:70px;">#</th>
              <th>Listing</th>
              <th>Price / night</th>
              <th>Capacity</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($listings as $listing)
              @php
                $images = json_decode($listing->listings_img, true);
                $thumb  = is_array($images) && count($images) ? $images[0] : null;
              @endphp
              <tr data-name="{{ Str::lower($listing->listings_name) }}" data-status="{{ $listing->listings_status }}">
                <td data-label="#">{{ $loop->iteration }}</td>

                <td data-label="Listing" class="mv-cell-block">
                  <div class="d-flex align-items-center gap-3">
                    @if($thumb)
                      <img src="{{ asset('storage/listing/' . $thumb) }}" alt="{{ $listing->listings_name }}" class="mv-listing-thumb">
                    @else
                      <span class="mv-listing-thumb mv-listing-thumb-ph"><i class="bi bi-image"></i></span>
                    @endif
                    <div class="min-w-0">
                      <div class="mv-cell-strong">{{ $listing->listings_name }}</div>
                      <div class="mv-cell-sub">{{ $listing->listings_slug }}</div>
                    </div>
                  </div>
                </td>

                <td data-label="Price / night">
                  <span class="mv-cell-strong">${{ number_format((float) $listing->listings_price, 2) }}</span>
                </td>

                <td data-label="Capacity" class="mv-cell-block">
                  <div class="mv-facts">
                    @php
                      $beds  = (int) ($listing->listings_number_of_beds ?? 1);
                      $rooms = $listing->listings_number_of_rooms;
                    @endphp
                    <span class="mv-fact"><i class="bi bi-people"></i> {{ $listing->listings_number_of_persons }} {{ Str::plural('guest', (int) $listing->listings_number_of_persons) }}</span>
                    <span class="mv-fact"><i class="bi bi-moon-stars"></i> {{ $beds }} {{ Str::plural('bed', $beds) }}</span>
                    <span class="mv-fact"><i class="bi bi-door-closed"></i>
                      {{ $rooms === null || $rooms === '' ? 'Rooms N/A' : $rooms . ' ' . Str::plural('room', (int) $rooms) }}
                    </span>
                  </div>
                </td>

                <td data-label="Status">
                  @if($listing->listings_status == 1)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-danger">Inactive</span>
                  @endif
                </td>

                <td data-label="" class="text-end">
                  <div class="d-inline-flex gap-2">
                    <a href="{{ url('admin/listings/' . $listing->listings_id . '/edit') }}" class="btn btn-sm btn-outline-secondary mv-btn-icon" title="Edit listing">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ url('admin/delete-listing/' . $listing->listings_id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete “{{ $listing->listings_name }}”? This cannot be undone.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger mv-btn-icon" title="Delete listing">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="mv-empty">
                    <i class="bi bi-door-closed"></i>
                    No listings yet. Add your first room to start taking bookings.
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="mv-empty d-none" id="listingsNoMatch">
      <i class="bi bi-search"></i>
      No listings match your search.
    </div>

  </section>

</main><!-- End #main -->

<script>
  (function () {
    var search   = document.getElementById('listingSearch');
    var status   = document.getElementById('listingStatus');
    var counter  = document.getElementById('listingCount');
    var noMatch  = document.getElementById('listingsNoMatch');
    var table    = document.getElementById('listingsTable');
    if (!table) return;

    var rows = Array.prototype.slice.call(table.querySelectorAll('tbody tr[data-name]'));

    function apply() {
      var term = (search.value || '').trim().toLowerCase();
      var want = status.value;
      var shown = 0;

      rows.forEach(function (row) {
        var matchesText   = !term || row.dataset.name.indexOf(term) !== -1;
        var matchesStatus = want === '' || row.dataset.status === want;
        var visible = matchesText && matchesStatus;
        row.style.display = visible ? '' : 'none';
        if (visible) shown++;
      });

      counter.textContent = 'Showing ' + shown + ' of ' + rows.length + ' listings';
      noMatch.classList.toggle('d-none', shown > 0 || rows.length === 0);
    }

    search.addEventListener('input', apply);
    status.addEventListener('change', apply);
    apply();
  })();
</script>

@include('admin.inc.footer')
