@include('admin.inc.header')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Bookings Calendar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
          <li class="breadcrumb-item active">Calendar</li>
        </ol>
      </nav>
    </div>
    <div>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="bi bi-list-task me-1"></i> List View</a>
    </div>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body p-4" style="position: relative;">
            <div class="row mb-4 align-items-center">
              <div class="col-md-4">
                <label class="form-label small fw-bold text-muted mb-1">Filter by Room Type</label>
                <select id="calendar-room-filter" class="form-select">
                  <option value="">All Rooms</option>
                  @foreach($listings as $listing)
                    <option value="{{ $listing->listings_id }}">{{ $listing->listings_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Calendar Loader Overlay -->
            <div id="calendar-loader" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.85); z-index:10; display:flex; justify-content:center; align-items:center; border-radius:8px;">
              <div style="text-align:center;">
                <i class="bi bi-arrow-repeat" style="font-size:32px; color:#4154f1; animation: spin 1s linear infinite;"></i>
                <p style="margin:10px 0 0; font-size:14px; color:#475569; font-weight:600;">Loading bookings...</p>
              </div>
            </div>

            <div id="booking-calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<style>
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>

@include('admin.inc.footer')

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('booking-calendar');
    var roomFilter = document.getElementById('calendar-room-filter');
    var loader = document.getElementById('calendar-loader');

    function showLoader() { if(loader) loader.style.display = 'flex'; }
    function hideLoader() { if(loader) loader.style.display = 'none'; }

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      loading: function(isLoading) {
        if (isLoading) showLoader(); else hideLoader();
      },
      events: function(info, successCallback, failureCallback) {
        showLoader();
        var url = '{{ route("admin.orders.calendar-events") }}';
        var params = new URLSearchParams();
        if (roomFilter && roomFilter.value) {
          params.append('listing_id', roomFilter.value);
        }
        
        fetch(url + '?' + params.toString())
          .then(function(res) { return res.json(); })
          .then(function(data) { hideLoader(); successCallback(data); })
          .catch(function(err) { hideLoader(); failureCallback(err); });
      },
      eventClick: function(info) {
        if (info.event.url) {
          window.location.href = info.event.url;
          info.jsEvent.preventDefault();
        }
      }
    });
    calendar.render();

    if (roomFilter) {
      roomFilter.addEventListener('change', function() {
        calendar.refetchEvents();
      });
    }
  });
</script>
