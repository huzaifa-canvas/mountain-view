@include('admin.inc.header', ['pageTitle' => $template['name']])

@php
  $renderUrl = route('admin.emails.render', $template['key']) . ($order->exists ? '?order=' . $order->id : '');
  $recipient = $order->customer_id
      ? ($order->customer->email ?? '—')
      : ($order->guest_email ?: '—');
@endphp

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>{{ $template['name'] }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.emails.index') }}">Email Templates</a></li>
          <li class="breadcrumb-item active">Preview</li>
        </ol>
      </nav>
    </div>
    <div class="mv-page-actions">
      <a href="{{ route('admin.emails.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> All templates
      </a>
      <a href="{{ $renderUrl }}" target="_blank" rel="noopener" class="btn btn-primary">
        <i class="bi bi-box-arrow-up-right me-1"></i> Open in new tab
      </a>
    </div>
  </div>

  <section class="section">

    @if($usingSample)
      <div class="alert alert-info">
        <i class="bi bi-info-circle me-1"></i>
        Showing sample booking data. Pick a real booking below to see the email with actual guest details.
      </div>
    @endif

    <div class="row g-4">

      <!-- Preview -->
      <div class="col-xl-8">
        <div class="card mb-0">
          <div class="card-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
              <h5 class="card-title mb-0">Inbox preview</h5>
              <div class="btn-group" role="group" aria-label="Preview width">
                <button type="button" class="btn btn-sm btn-primary" data-mv-width="100%">
                  <i class="bi bi-display me-1"></i> Desktop
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-mv-width="390px">
                  <i class="bi bi-phone me-1"></i> Mobile
                </button>
              </div>
            </div>

            <!-- Envelope header, the way a mail client shows it -->
            <div class="mv-mail-head">
              <div class="mv-dl">
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Subject</span>
                  <span class="mv-dl-val">{{ $template['subject'] }}</span>
                </div>
                <div class="mv-dl-row">
                  <span class="mv-dl-key">To</span>
                  <span class="mv-dl-val">{{ $template['audience'] }} &lt;{{ $recipient }}&gt;</span>
                </div>
                <div class="mv-dl-row">
                  <span class="mv-dl-key">From</span>
                  <span class="mv-dl-val">{{ config('mail.from.name') }} &lt;{{ config('mail.from.address') }}&gt;</span>
                </div>
              </div>
            </div>

            <div class="mv-mail-stage">
              <iframe id="mv-mail-frame"
                      src="{{ $renderUrl }}"
                      title="{{ $template['name'] }} preview"
                      loading="lazy"></iframe>
            </div>

          </div>
        </div>
      </div>

      <!-- Meta -->
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">About this email</h5>
            <p style="font-size:.89rem;color:var(--mv-text-2);">{{ $template['summary'] }}</p>

            <div class="mv-dl mv-dl-stack">
              <div class="mv-dl-row">
                <span class="mv-dl-key">Goes to</span>
                <span class="mv-dl-val">{{ $template['audience'] }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Sending</span>
                <span class="mv-dl-val">
                  <span class="badge {{ $template['automatic'] ? 'bg-success' : 'bg-secondary' }}">
                    {{ $template['automatic'] ? 'Automatic' : 'Manual' }}
                  </span>
                </span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Trigger</span>
                <span class="mv-dl-val">{{ $template['trigger'] }}</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Blade file</span>
                <span class="mv-dl-val" style="font-size:.78rem;word-break:break-all;">resources/views/{{ str_replace('.', '/', $template['view']) }}.blade.php</span>
              </div>
              <div class="mv-dl-row">
                <span class="mv-dl-key">Sent from</span>
                <span class="mv-dl-val" style="font-size:.78rem;">{{ $template['origin'] }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Preview with a booking</h5>

            {{-- Search first: the picker only ever lists a capped set, so an
                 older booking is reached by searching for it, not by scrolling. --}}
            <form method="GET" action="{{ route('admin.emails.show', $template['key']) }}" class="mb-3">
              @if($order->exists)
                <input type="hidden" name="order" value="{{ $order->id }}">
              @endif
              <label class="form-label" for="orderSearch">Find a booking</label>
              <div class="input-group">
                <input type="search" name="q" id="orderSearch" class="form-control"
                       placeholder="Order #, name or email…" value="{{ $search }}">
                <button type="submit" class="btn btn-outline-secondary" aria-label="Search bookings">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>

            @if($orders->isEmpty())
              @if($search !== '')
                <p class="mv-cell-sub mb-2">No bookings match “{{ $search }}”.</p>
                <a href="{{ route('admin.emails.show', $template['key']) }}" class="btn btn-outline-secondary w-100">
                  <i class="bi bi-x-circle me-1"></i> Clear search
                </a>
              @else
                <p class="mv-cell-sub mb-0">No bookings yet, so only the sample data is available.</p>
              @endif
            @else
              <form method="GET" action="{{ route('admin.emails.show', $template['key']) }}">
                @if($search !== '')
                  <input type="hidden" name="q" value="{{ $search }}">
                @endif
                <label class="form-label" for="orderPicker">
                  {{ $search !== '' ? 'Matching bookings' : 'Recent bookings' }}
                </label>
                <select name="order" id="orderPicker" class="form-select mb-2" onchange="this.form.submit()">
                  <option value="">Sample booking data</option>
                  @foreach($orders as $row)
                    <option value="{{ $row->id }}" {{ $order->exists && $order->id == $row->id ? 'selected' : '' }}>
                      #{{ $row->order_number }}{{ $row->guest_name ? ' — ' . $row->guest_name : '' }}
                    </option>
                  @endforeach
                </select>
                <p class="mv-cell-sub">
                  Showing {{ $orders->count() }} {{ Str::plural('booking', $orders->count()) }}.
                  Search above to reach any other.
                </p>
                <noscript><button type="submit" class="btn btn-primary w-100 mb-2">Load booking</button></noscript>
              </form>

              @if($order->exists)
                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-secondary w-100">
                  <i class="bi bi-receipt me-1"></i> Open booking #{{ $order->order_number }}
                </a>
              @endif
            @endif
          </div>
        </div>

      </div>
    </div>

  </section>

</main>

<style>
  .mv-mail-head {
    border: 1px solid var(--mv-border);
    border-bottom: 0;
    border-radius: var(--mv-radius) var(--mv-radius) 0 0;
    background: var(--mv-surface-2);
    padding: 16px 18px;
  }
  .mv-mail-stage {
    border: 1px solid var(--mv-border);
    border-radius: 0 0 var(--mv-radius) var(--mv-radius);
    background: #edf1f5;
    padding: 18px;
    display: flex;
    justify-content: center;
  }
  [data-theme="dark"] .mv-mail-stage { background: #0E0B0A; }
  #mv-mail-frame {
    width: 100%;
    max-width: 100%;
    height: 760px;
    border: 0;
    border-radius: var(--mv-radius-sm);
    background: #ffffff;
    transition: width .25s ease;
  }
  @media (max-width: 575px) {
    .mv-mail-stage { padding: 10px; }
  }
</style>

<script>
  (function () {
    var frame = document.getElementById('mv-mail-frame');
    if (!frame) return;

    // Grow the frame to its content so the whole email is visible without a
    // second scrollbar. Same-origin, so the document is readable; if a browser
    // ever blocks it the CSS height above stands in.
    function fit() {
      try {
        var doc = frame.contentDocument;
        if (!doc || !doc.body) return;
        frame.style.height = Math.max(400, doc.body.scrollHeight + 32) + 'px';
      } catch (e) {}
    }

    frame.addEventListener('load', function () {
      fit();
      // Images and webfonts settle after load and change the height
      setTimeout(fit, 250);
      setTimeout(fit, 1000);
    });

    document.querySelectorAll('[data-mv-width]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        frame.style.width = btn.dataset.mvWidth;

        document.querySelectorAll('[data-mv-width]').forEach(function (other) {
          other.classList.toggle('btn-primary', other === btn);
          other.classList.toggle('btn-outline-secondary', other !== btn);
        });

        // A narrower frame reflows the email, so re-measure after the transition
        setTimeout(fit, 300);
      });
    });

    window.addEventListener('resize', fit);
  })();
</script>

@include('admin.inc.footer')
