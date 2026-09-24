@include('admin.inc.header', ['pageTitle' => 'Members'])

@php
  $money = fn ($v) => $currency . ' ' . number_format((float) $v, 2);
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>Members</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Members</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-cart-check me-1"></i> All bookings
      </a>
    </div>
  </div>

  <section class="section">

    <p class="mb-3" style="color:var(--mv-text-2);max-width:70ch;">
      Guests who created an account and earn loyalty points. One-off bookings made without
      signing up appear under <a href="{{ route('admin.orders.index') }}">Bookings &amp; Orders</a> instead.
    </p>

    <div class="mv-chips mb-3">
      <span class="mv-chip"><i class="bi bi-people"></i> {{ number_format($summary['count']) }} {{ $search !== '' ? 'matching' : 'total' }} {{ Str::plural('member', $summary['count']) }}</span>
      <span class="mv-chip"><i class="bi bi-star"></i> {{ number_format($summary['points']) }} points outstanding</span>
      @if($search !== '')
        <a href="{{ route('admin.members.index') }}" class="mv-chip"><i class="bi bi-x-circle"></i> Clear search</a>
      @endif
    </div>

    <form method="GET" action="{{ route('admin.members.index') }}" class="mv-filters">
      <div class="row g-3 align-items-end">
        <div class="col-lg-6 col-md-8">
          <label class="form-label" for="memberSearch">Search members</label>
          <input type="search" id="memberSearch" name="search" class="form-control"
                 placeholder="Name, email, phone or city…" value="{{ $search }}">
        </div>
        <div class="col-lg-3 col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-search me-1"></i> Search</button>
          <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
        </div>
      </div>
    </form>

    <div class="mv-table-wrap">
      <div class="table-responsive">
        <table class="table mv-responsive-table align-middle">
          <thead>
            <tr>
              <th>Member</th>
              <th>Contact</th>
              <th>Location</th>
              <th>Bookings</th>
              <th>Spent</th>
              <th>Points</th>
              <th>Joined</th>
              <th class="text-end">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @forelse($customers as $member)
              @php
                $name = trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) ?: 'Unnamed member';
                $initials = collect([$member->first_name, $member->last_name])
                    ->filter()->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->implode('');
                $location = implode(', ', array_filter([$member->city, $member->state]));
              @endphp
              <tr>
                <td data-label="Member" class="mv-cell-block">
                  <div class="d-flex align-items-center gap-3">
                    <span class="mv-avatar">{{ $initials ?: 'M' }}</span>
                    <div class="min-w-0">
                      <a href="{{ route('admin.members.show', $member->id) }}" class="mv-cell-strong">{{ $name }}</a>
                      <div class="mv-cell-sub">#{{ $member->id }}</div>
                    </div>
                  </div>
                </td>

                <td data-label="Contact" class="mv-cell-block">
                  <span class="mv-cell-strong">{{ $member->email }}</span>
                  <div class="mv-cell-sub">{{ $member->phone ?: 'No phone' }}</div>
                </td>

                <td data-label="Location">{{ $location ?: '—' }}</td>

                <td data-label="Bookings">
                  <span class="mv-cell-strong">{{ $member->orders_count }}</span>
                </td>

                <td data-label="Spent" class="mv-nowrap">
                  <span class="mv-cell-strong">{{ $money($member->total_spent ?? 0) }}</span>
                </td>

                <td data-label="Points">
                  <span class="badge bg-warning">{{ number_format($member->loyalty_points) }} pts</span>
                </td>

                <td data-label="Joined" class="mv-nowrap">{{ $member->created_at?->format('M d, Y') ?? '—' }}</td>

                <td data-label="" class="text-end">
                  <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-outline-secondary">
                    Details <i class="bi bi-chevron-right ms-1"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8">
                  <div class="mv-empty">
                    <i class="bi bi-people"></i>
                    {{ $search !== '' ? 'No members match this search.' : 'No one has signed up for a member account yet.' }}
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($customers->hasPages())
      <div class="d-flex justify-content-center mt-4">
        {{ $customers->appends(request()->query())->links() }}
      </div>
    @endif

  </section>

</main>

@include('admin.inc.footer')
