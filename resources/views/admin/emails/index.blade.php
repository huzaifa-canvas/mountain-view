@include('admin.inc.header', ['pageTitle' => 'Email Templates'])

<main id="main" class="main">

  <div class="mv-page-head">
    <div class="pagetitle mb-0">
      <h1>Email Templates</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Email Templates</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="section">

    <p class="mb-3" style="color:var(--mv-text-2);max-width:70ch;">
      These are the emails MountainView sends. Open any one to see exactly what lands in the
      recipient's inbox — on desktop and on a phone — without having to place a test booking.
    </p>

    <div class="mv-chips mb-4">
      <span class="mv-chip"><i class="bi bi-envelope"></i> {{ count($templates) }} templates</span>
      <span class="mv-chip"><i class="bi bi-inbox"></i> Admin notices go to {{ $adminEmail ?: 'no address set' }}</span>
      <span class="mv-chip"><i class="bi bi-gear"></i> Mailer: {{ $mailer }}</span>
    </div>

    @if($mailer === 'log')
      <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-1"></i>
        The mailer is set to <strong>log</strong>, so nothing is actually delivered right now —
        messages are written to <code>storage/logs/laravel.log</code> instead. Previews below are unaffected.
      </div>
    @endif

    <div class="row g-4">
      @foreach($templates as $template)
        <div class="col-xl-6">
          <div class="card h-100 mb-0">
            <div class="card-body d-flex flex-column">

              <div class="d-flex align-items-start gap-3 mb-3">
                <span class="mv-stat-icon {{ $template['tone'] }}"><i class="bi {{ $template['icon'] }}"></i></span>
                <div class="flex-grow-1 min-w-0">
                  <h3 style="font-size:1.05rem;margin-bottom:3px;">{{ $template['name'] }}</h3>
                  <div class="mv-facts">
                    <span class="mv-fact"><i class="bi bi-person"></i> {{ $template['audience'] }}</span>
                    <span class="mv-fact">
                      <i class="bi {{ $template['automatic'] ? 'bi-lightning-charge' : 'bi-hand-index' }}"></i>
                      {{ $template['automatic'] ? 'Automatic' : 'Sent manually' }}
                    </span>
                  </div>
                </div>
              </div>

              <p class="mb-3" style="font-size:.89rem;color:var(--mv-text-2);">{{ $template['summary'] }}</p>

              <div class="mv-dl mv-dl-stack mb-3">
                <div class="mv-dl-row">
                  <span class="mv-dl-key">Subject line</span>
                  <span class="mv-dl-val" style="color:var(--mv-text);font-weight:500;">{{ $template['subject'] }}</span>
                </div>
                <div class="mv-dl-row">
                  <span class="mv-dl-key">When it goes out</span>
                  <span class="mv-dl-val">{{ $template['trigger'] }}</span>
                </div>
              </div>

              <div class="mt-auto pt-2 d-flex flex-wrap gap-2">
                <a href="{{ route('admin.emails.show', $template['key']) }}" class="btn btn-primary">
                  <i class="bi bi-eye me-1"></i> Preview email
                </a>
                <a href="{{ route('admin.emails.render', $template['key']) }}" target="_blank" rel="noopener" class="btn btn-outline-secondary">
                  <i class="bi bi-box-arrow-up-right me-1"></i> Open in new tab
                </a>
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>

  </section>

</main>

@include('admin.inc.footer')
