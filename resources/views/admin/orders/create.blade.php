@include('admin.inc.header', ['pageTitle' => 'New walk-in booking'])

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>New walk-in booking</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Bookings</a></li>
          <li class="breadcrumb-item active">New booking</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to bookings
      </a>
    </div>
  </div>

  <section class="section">

    <p class="text-muted mb-3">
      For a guest who arrives without booking online. The room limit is checked before the booking is saved, so these dates cannot be oversold.
    </p>

    @if($errors->any())
      <div class="alert alert-danger">
        <strong>Please check the form:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data" id="walkin-form">
      @csrf

      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Stay</h5>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="check_in">Check in <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="check_in" name="check_in"
                         value="{{ old('check_in', now()->toDateString()) }}" autocomplete="off" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="check_out">Check out <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="check_out" name="check_out"
                         value="{{ old('check_out', now()->addDay()->toDateString()) }}" autocomplete="off" required>
                </div>

                <div class="col-md-12">
                  <label class="form-label d-flex align-items-center gap-2" for="listings_id">
                    <span>Room <span class="text-danger">*</span></span>
                    <span class="mv-inline-loader" id="rooms-loader" hidden>
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      <span>Checking availability&hellip;</span>
                    </span>
                  </label>
                  <select class="form-select" id="listings_id" name="listings_id" required disabled
                          data-old="{{ old('listings_id') }}">
                    <option value="">Pick your dates first&hellip;</option>
                  </select>
                  <div class="form-text" id="rooms-hint">Rooms that are full on these dates cannot be picked.</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="rooms">Rooms <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="rooms" name="rooms"
                         min="1" step="1" value="{{ old('rooms', 1) }}" required>
                  <div class="form-text" id="rooms-left">&nbsp;</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="pets">Pets</label>
                  <input type="number" class="form-control" id="pets" name="pets" min="0" step="1" value="{{ old('pets', 0) }}">
                  <div class="form-text">{{ $currency }} {{ number_format($settings->pet_fee ?? 25, 2) }} each</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="laundry_qty">Laundry loads</label>
                  <input type="number" class="form-control" id="laundry_qty" name="laundry_qty" min="0" step="1" value="{{ old('laundry_qty', 0) }}">
                  <div class="form-text">{{ $currency }} {{ number_format($settings->laundry_fee ?? 25, 2) }} each</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="booking_type">Booking type</label>
                  <select class="form-select" id="booking_type" name="booking_type">
                    <option value="Walk-in" @selected(old('booking_type', 'Walk-in') === 'Walk-in')>Walk-in</option>
                    <option value="Personal" @selected(old('booking_type') === 'Personal')>Personal</option>
                    <option value="Business" @selected(old('booking_type') === 'Business')>Business</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Guest</h5>

              <div class="row g-3">
                <div class="col-md-12">
                  <label class="form-label" for="customer_id">Existing member</label>
                  <select class="form-select" id="customer_id" name="customer_id">
                    <option value="">Not a member &mdash; walk-in guest</option>
                    @foreach($customers as $customer)
                      <option value="{{ $customer->id }}"
                              data-name="{{ trim($customer->first_name . ' ' . $customer->last_name) }}"
                              data-email="{{ $customer->email }}"
                              @selected(old('customer_id') == $customer->id)>
                        {{ trim($customer->first_name . ' ' . $customer->last_name) }} &mdash; {{ $customer->email }}
                      </option>
                    @endforeach
                  </select>
                  <div class="form-text">Link the booking to a member so it shows in their account and earns points.</div>
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="guest_name">Guest name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="guest_email">Email</label>
                  <input type="email" class="form-control" id="guest_email" name="guest_email" value="{{ old('guest_email') }}">
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="guest_phone">Phone</label>
                  <input type="text" class="form-control" id="guest_phone" name="guest_phone" value="{{ old('guest_phone') }}">
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="guest_vehicle_number">Vehicle number</label>
                  <input type="text" class="form-control" id="guest_vehicle_number" name="guest_vehicle_number" value="{{ old('guest_vehicle_number') }}">
                </div>

                <div class="col-md-12">
                  <label class="form-label" for="guest_address">Address</label>
                  <input type="text" class="form-control" id="guest_address" name="guest_address" value="{{ old('guest_address') }}">
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="guest_city">City</label>
                  <input type="text" class="form-control" id="guest_city" name="guest_city" value="{{ old('guest_city') }}">
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="guest_province">Province</label>
                  <input type="text" class="form-control" id="guest_province" name="guest_province" value="{{ old('guest_province') }}">
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="guest_postal_code">Postal code</label>
                  <input type="text" class="form-control" id="guest_postal_code" name="guest_postal_code" value="{{ old('guest_postal_code') }}">
                </div>

                <div class="col-md-12">
                  <label class="form-label" for="id_proof">Customer ID proof</label>
                  <input type="file" class="form-control" id="id_proof" name="id_proof" accept="image/*,application/pdf">
                  <div class="form-text">Optional. A photo or scan, up to 5 MB.</div>
                </div>

                <div class="col-md-12">
                  <label class="form-label" for="notes">Notes</label>
                  <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Payment</h5>

              <label class="form-label" for="payment_status">Status <span class="text-danger">*</span></label>
              <select class="form-select mb-3" id="payment_status" name="payment_status" required>
                <option value="paid" @selected(old('payment_status', 'paid') === 'paid')>Paid at the desk</option>
                <option value="pending" @selected(old('payment_status') === 'pending')>Pending &mdash; pay later</option>
              </select>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="check_in_now" name="check_in_now"
                       @checked(old('check_in_now'))>
                <label class="form-check-label" for="check_in_now">
                  Guest is checking in now
                </label>
              </div>

              <hr>

              <div class="mv-dl mv-dl-stack" id="price-breakdown">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Rooms</span><span id="p-rooms">&mdash;</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Pet fee</span><span id="p-pets">&mdash;</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Laundry</span><span id="p-laundry">&mdash;</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ $settings->tax_label ?? 'Tax' }} ({{ rtrim(rtrim(number_format($settings->tax_rate ?? 15, 2), '0'), '.') }}%)</span><span id="p-tax">&mdash;</span></div>
                <hr class="my-2">
                <div class="d-flex justify-content-between fw-bold fs-5"><span>Total</span><span id="p-total">&mdash;</span></div>
              </div>

              <p class="text-muted mt-3 mb-0" style="font-size:12px;">
                Worked out the same way the website does. The saved figure is calculated again on the server.
              </p>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Save</h5>
              <button type="submit" class="btn btn-primary w-100" id="walkin-submit">
                <i class="bi bi-check2-circle"></i> Create booking
              </button>
              <a href="{{ route('admin.orders.index') }}" class="btn btn-light w-100 mt-2">Cancel</a>
            </div>
          </div>

        </div>
      </div>
    </form>

  </section>
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
  /* The day badges come from the public site's stylesheet, which the admin
     does not load, so the same rules are repeated here. */
  .flatpickr-day { position: relative; }
  .mv-day-left {
    position: absolute; left: 0; right: 0; bottom: 1px;
    font-size: 9px; line-height: 1; font-weight: 600;
    color: var(--mv-success, #0F7B6C);
    pointer-events: none;
  }
  .mv-day-left.is_full { color: var(--mv-danger, #C62F14); }
  .flatpickr-day.flatpickr-disabled .mv-day-left { opacity: .45; }

  .mv-inline-loader {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 12px; font-weight: 600; color: var(--mv-brand, #184E77);
  }
  .mv-inline-loader[hidden] { display: none; }

  /* While a lookup is running the panel it feeds is dimmed and inert, so
     nobody submits a figure that is about to change under them. */
  .mv-busy { position: relative; opacity: .55; pointer-events: none; }

  .mv-form-busy #walkin-submit { pointer-events: none; opacity: .65; }
</style>

<script>
(function () {
  var listing  = document.getElementById('listings_id');
  var checkIn  = document.getElementById('check_in');
  var checkOut = document.getElementById('check_out');
  var rooms    = document.getElementById('rooms');
  var pets     = document.getElementById('pets');
  var laundry  = document.getElementById('laundry_qty');
  var left     = document.getElementById('rooms-left');
  var hint     = document.getElementById('rooms-hint');
  var loader   = document.getElementById('rooms-loader');
  var member   = document.getElementById('customer_id');
  var guestName  = document.getElementById('guest_name');
  var guestEmail = document.getElementById('guest_email');
  var priceBox = document.getElementById('price-breakdown');

  var CURRENCY = @json($currency);
  var TAX_RATE = {{ (float) ($settings->tax_rate ?? 15) }};
  var PET_FEE  = {{ (float) ($settings->pet_fee ?? 25) }};
  var LAUNDRY_FEE = {{ (float) ($settings->laundry_fee ?? 25) }};

  var available = {};   // listing id -> what the server last told us
  var inFlight  = null; // the current lookup, so a stale reply cannot win

  function money(n) { return CURRENCY + ' ' + n.toFixed(2); }

  function nights() {
    if (!checkIn.value || !checkOut.value) return 0;
    var d = Math.round((new Date(checkOut.value) - new Date(checkIn.value)) / 86400000);
    return d > 0 ? d : 0;
  }

  function busy(on) {
    loader.hidden = !on;
    priceBox.classList.toggle('mv-busy', on);
    document.body.classList.toggle('mv-form-busy', on);
    listing.disabled = on || !listing.options.length || listing.options.length < 2;
  }

  function price() {
    var opt = listing.options[listing.selectedIndex];
    var rate = opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;
    var roomTotal = rate * (parseInt(rooms.value, 10) || 0) * nights();
    var petTotal = (parseInt(pets.value, 10) || 0) * PET_FEE;
    var laundryTotal = (parseInt(laundry.value, 10) || 0) * LAUNDRY_FEE;
    var sub = roomTotal + petTotal + laundryTotal;
    var tax = sub * (TAX_RATE / 100);

    document.getElementById('p-rooms').textContent = money(roomTotal);
    document.getElementById('p-pets').textContent = money(petTotal);
    document.getElementById('p-laundry').textContent = money(laundryTotal);
    document.getElementById('p-tax').textContent = money(tax);
    document.getElementById('p-total').textContent = money(sub + tax);
  }

  function showRoomsLeft() {
    var room = available[listing.value];

    if (!listing.value || !room) { left.innerHTML = '&nbsp;'; return; }

    if (room.remaining === null) {
      left.textContent = 'No room limit set for this room type.';
      left.className = 'form-text';
      rooms.removeAttribute('max');
      return;
    }

    rooms.max = room.remaining;
    if (parseInt(rooms.value, 10) > room.remaining) {
      rooms.value = room.remaining > 0 ? room.remaining : 1;
    }

    left.textContent = room.remaining + ' of ' + room.total + ' free for these dates.';
    left.className = 'form-text text-success fw-semibold';
  }

  function fillRooms(data) {
    var keep = listing.value || listing.dataset.old || '';
    listing.innerHTML = '';
    available = {};

    var placeholder = new Option('Choose a room…', '');
    listing.add(placeholder);

    var anyFree = false;

    data.rooms.forEach(function (room) {
      available[room.id] = room;

      var label = room.name + ' — ' + money(room.price) + '/night';
      label += room.remaining === null
        ? ' — no limit set'
        : (room.sold_out ? ' — fully booked' : ' — ' + room.remaining + ' of ' + room.total + ' free');

      var opt = new Option(label, room.id);
      opt.dataset.price = room.price;
      opt.disabled = room.sold_out;
      listing.add(opt);

      if (!room.sold_out) anyFree = true;
    });

    if (keep && available[keep] && !available[keep].sold_out) {
      listing.value = keep;
    }
    listing.dataset.old = '';

    hint.textContent = anyFree
      ? 'Rooms that are full on these dates cannot be picked.'
      : 'Every room is fully booked for these dates.';
    hint.className = anyFree ? 'form-text' : 'form-text text-danger fw-semibold';

    showRoomsLeft();
    price();
  }

  // Ask the server what is free, rather than trusting the total room count:
  // other bookings may already hold some of these nights.
  function loadRooms() {
    if (nights() < 1) {
      listing.innerHTML = '';
      listing.add(new Option('Pick your dates first…', ''));
      listing.disabled = true;
      hint.textContent = 'Check-out has to be after check-in.';
      hint.className = 'form-text';
      left.innerHTML = '&nbsp;';
      price();
      return;
    }

    var token = {};
    inFlight = token;
    busy(true);

    var url = '{{ route('admin.orders.availability') }}'
      + '?check_in=' + encodeURIComponent(checkIn.value)
      + '&check_out=' + encodeURIComponent(checkOut.value);

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(r.status); })
      .then(function (data) {
        // A slower earlier request must not overwrite a newer answer
        if (inFlight !== token) return;
        fillRooms(data);
      })
      .catch(function () {
        if (inFlight !== token) return;
        hint.textContent = 'Could not check availability. Change a date to try again.';
        hint.className = 'form-text text-danger';
      })
      .finally(function () {
        if (inFlight !== token) return;
        inFlight = null;
        busy(false);
        listing.disabled = nights() < 1;
      });
  }

  // The same picker, and the same per-night counts, as the public booking page:
  // staff and guests should be reading one calendar, not two.
  var mvCalendar = {};

  function mvDateKey(date) {
    return date.getFullYear()
      + '-' + String(date.getMonth() + 1).padStart(2, '0')
      + '-' + String(date.getDate()).padStart(2, '0');
  }

  function mvNightIsFull(date) {
    var info = mvCalendar[mvDateKey(date)];
    return !!(info && info.full);
  }

  function mvDecorateDay(dayElem) {
    var info = mvCalendar[mvDateKey(dayElem.dateObj)];
    if (!info) return;

    var old = dayElem.querySelector('.mv-day-left');
    if (old) old.remove();

    var tag = document.createElement('span');
    tag.className = 'mv-day-left' + (info.full ? ' is_full' : '');
    tag.textContent = info.full ? 'Full' : info.free;
    dayElem.appendChild(tag);

    dayElem.title = info.full
      ? 'No rooms left on this date'
      : info.free + (info.free === 1 ? ' room' : ' rooms') + ' left';
  }

  var checkInPicker = flatpickr(checkIn, {
    dateFormat: 'Y-m-d',
    altInput: true,
    altFormat: 'M j, Y',
    minDate: 'today',
    disable: [mvNightIsFull],
    onDayCreate: function (dObj, dStr, fp, dayElem) { mvDecorateDay(dayElem); },
    onChange: function (dates) {
      if (dates.length) {
        var next = new Date(dates[0]);
        next.setDate(next.getDate() + 1);
        checkOutPicker.set('minDate', next);

        var out = checkOutPicker.selectedDates[0];
        if (!out || out <= dates[0]) checkOutPicker.setDate(next, true);
      }
      loadRooms();
    }
  });

  // new Date('2026-09-25') is parsed as UTC midnight, which in a timezone ahead
  // of UTC lands later the same day than the date flatpickr holds. That made a
  // pre-filled check-out fall below its own minDate and get cleared, so the
  // date is rebuilt in local time instead.
  function todayKey() {
    return mvDateKey(new Date());
  }

  function dayAfter(ymd) {
    if (!ymd) return null;
    var p = ymd.split('-');
    var d = new Date(+p[0], +p[1] - 1, +p[2]);
    d.setDate(d.getDate() + 1);
    return d;
  }

  var checkOutPicker = flatpickr(checkOut, {
    dateFormat: 'Y-m-d',
    altInput: true,
    altFormat: 'M j, Y',
    // Never before tomorrow, and never on or before the arrival date
    minDate: dayAfter(checkIn.value) || dayAfter(todayKey()),
    // The departure day itself is not slept in, so it is never blocked
    onDayCreate: function (dObj, dStr, fp, dayElem) { mvDecorateDay(dayElem); },
    onChange: loadRooms
  });

  function loadCalendar() {
    fetch('{{ route("room.availability.calendar") }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(r.status); })
      .then(function (data) {
        mvCalendar = (data && data.dates) || {};
        checkInPicker.redraw();
        checkOutPicker.redraw();
      })
      .catch(function () { /* the picker still works, just without counts */ });
  }

  listing.addEventListener('change', function () { showRoomsLeft(); price(); });

  [rooms, pets, laundry].forEach(function (el) {
    el.addEventListener('input', price);
  });

  // Picking a member fills in the name and email the desk would otherwise retype
  member.addEventListener('change', function () {
    var opt = member.options[member.selectedIndex];
    if (!opt || !opt.value) return;
    if (!guestName.value) guestName.value = opt.dataset.name || '';
    if (!guestEmail.value) guestEmail.value = opt.dataset.email || '';
  });

  // Saving takes a round trip too, so the button says so and cannot be
  // double-clicked into two bookings.
  document.getElementById('walkin-form').addEventListener('submit', function () {
    var btn = document.getElementById('walkin-submit');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving booking…';
  });

  loadCalendar();
  loadRooms();
  price();
})();
</script>

@include('admin.inc.footer')
