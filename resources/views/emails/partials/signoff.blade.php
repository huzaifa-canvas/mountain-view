@php
    /*
     * One sign-off for every guest email, so the owner's name and the policy
     * links are set in one place rather than repeated in each template.
     * The name comes from Global Settings; the motel's own wording is used
     * until someone fills it in.
     */
    $mvSettings = \DB::table('general_setting')->where('general_setting_id', '1')->first();
    $mvManager  = trim($mvSettings->manager_name ?? '') ?: 'Mountain View Motel Management';
    $mvTitle    = trim($mvSettings->manager_title ?? '');
    $mvClosing  = $closing ?? 'Looking forward to welcoming you again soon!';
@endphp

<p style="margin-top:28px; font-weight:600; color:#334155;">
    {{ $mvClosing }}<br>
    <span style="color:#184E77; font-weight:700;">{{ $mvManager }}</span>
    @if($mvTitle)
        <br><span style="color:#64748b; font-weight:600; font-size:13px;">{{ $mvTitle }}</span>
    @endif
</p>

<p style="margin-top:22px; padding-top:16px; border-top:1px solid #e2e8f0; font-size:12px; color:#64748b; line-height:1.6;">
    Our full house rules, cancellation policy and terms are on our website:<br>
    <a href="{{ url('term-condition') }}" style="color:#184E77; font-weight:700;">Terms &amp; Conditions</a>
    &nbsp;&middot;&nbsp;
    <a href="{{ url('privacy') }}" style="color:#184E77; font-weight:700;">Privacy Policy</a>
    &nbsp;&middot;&nbsp;
    <a href="{{ url('cookie-privacy') }}" style="color:#184E77; font-weight:700;">Cookie Policy</a>
</p>
