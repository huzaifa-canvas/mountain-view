@include('front.inc.header')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    .fb_icon_done { background: #DBEAFE !important; color: #1E40AF !important; }
    .fb_prev_review {
        text-align: left; background: #F8FAFC; border: 1px solid #E2E8F0;
        border-radius: 12px; padding: 16px 18px; margin: 0 auto 24px; max-width: 520px;
    }
    .fb_prev_label {
        font-size: 11px; font-weight: 700; color: #94A3B8;
        text-transform: uppercase; letter-spacing: .7px; margin-bottom: 8px;
    }
    .fb_prev_meta { font-size: 13px; font-weight: 700; color: #184E77; margin-bottom: 6px; }
    .fb_prev_msg { font-size: 14px; color: #475569; margin: 0; white-space: pre-line; }
    .feedback_section {
        padding: 70px 0 90px;
        background: #f8fafc;
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
    }
    .feedback_card {
        max-width: 680px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .feedback_header {
        background: linear-gradient(135deg, #184E77, #1e6091);
        color: #ffffff;
        padding: 32px 30px;
        text-align: center;
    }
    .feedback_header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
    }
    .feedback_header p {
        margin: 6px 0 0;
        font-size: 14px;
        opacity: 0.85;
    }
    .feedback_body {
        padding: 32px 30px;
    }
    .fb_order_info {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .fb_order_info .label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #64748b;
    }
    .fb_order_info .value {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }
    .fb_field {
        margin-bottom: 22px;
    }
    .fb_label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .fb_label .req { color: #ef4444; }
    .fb_input, .fb_select, .fb_textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
        background: #f8fafc;
        transition: all 0.25s ease;
        box-sizing: border-box;
    }
    .fb_input:focus, .fb_select:focus, .fb_textarea:focus {
        outline: none;
        border-color: #184E77;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(24, 78, 119, 0.1);
    }
    .fb_hint {
        display: flex; flex-wrap: wrap; gap: 6px 14px;
        justify-content: space-between; align-items: center;
        margin-top: 7px; font-size: 12px; color: #94a3b8; font-weight: 600;
    }
    .fb_hint i { color: #d97706; margin-right: 4px; }
    .fb_hint span:last-child { font-variant-numeric: tabular-nums; }
    .fb_textarea {
        min-height: 120px;
        resize: vertical;
    }
    .fb_checkbox_row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 6px;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
    .fb_checkbox_row input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #184E77;
        cursor: pointer;
    }
    .fb_checkbox_row label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
    }
    .fb_submit_btn {
        background: linear-gradient(135deg, #184E77, #1e6091);
        color: #ffffff;
        border: none;
        padding: 14px 32px;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(24, 78, 119, 0.3);
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
    }
    .fb_submit_btn:hover {
        background: linear-gradient(135deg, #123957, #184E77);
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(24, 78, 119, 0.4);
    }
    .fb_success_box {
        text-align: center;
        padding: 50px 30px;
    }
    .fb_success_icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 20px;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
</style>

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">GUEST FEEDBACK</h6>
        </div> 
    </div>
</section>

<section class="feedback_section">
    <div class="container">
        <div class="feedback_card">
            <div class="feedback_header">
                <h2><i class="fa-solid fa-comments me-2"></i> Share Your Experience</h2>
                <p>Your feedback helps us improve our services</p>
            </div>

            <div class="feedback_body">
                @if($existingFeedback && !session('feedback_success'))
                    <div class="fb_success_box">
                        <div class="fb_success_icon fb_icon_done">
                            <i class="fa-solid fa-comment-dots"></i>
                        </div>
                        <h3 style="font-weight:800; color:#0f172a; margin-bottom:8px;">You have already reviewed this stay</h3>
                        <p style="color:#64748b; font-size:14px; margin-bottom:22px;">
                            We received your feedback for booking <strong>#{{ $order->order_number }}</strong>
                            on {{ $existingFeedback->created_at->format('F d, Y') }}. Thank you &mdash; one review per booking is all we need.
                        </p>

                        @if(session('feedback_duplicate'))
                            <p style="color:#92400e; background:#FEF3C7; border:1px solid #FDE68A; border-radius:10px; padding:11px 15px; font-size:13px; margin-bottom:22px;">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                Your feedback for this booking was already recorded, so this one was not saved again.
                            </p>
                        @endif

                        <div class="fb_prev_review">
                            <div class="fb_prev_label">What you told us</div>
                            <div class="fb_prev_meta">{{ $existingFeedback->category }}</div>
                            <p class="fb_prev_msg">{{ $existingFeedback->message }}</p>
                        </div>

                        <a href="{{ url('/') }}" class="fb_submit_btn" style="display:inline-flex; width:auto; text-decoration:none;">
                            <i class="fa-solid fa-house"></i> Return Home
                        </a>
                    </div>
                @elseif(session('feedback_success'))
                    <div class="fb_success_box">
                        <div class="fb_success_icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h3 style="font-weight:800; color:#0f172a; margin-bottom:8px;">Thank You!</h3>
                        <p style="color:#64748b; font-size:14px; margin-bottom:24px;">Your feedback has been submitted successfully. We truly appreciate you taking the time to share your thoughts.</p>
                        <a href="{{ url('/') }}" class="fb_submit_btn" style="display:inline-flex; width:auto; text-decoration:none;">
                            <i class="fa-solid fa-house"></i> Return Home
                        </a>
                    </div>
                @else
                    <div class="fb_order_info">
                        <div>
                            <div class="label">Booking Reference</div>
                            <div class="value">#{{ $order->order_number }}</div>
                        </div>
                        <div>
                            <div class="label">Guest</div>
                            <div class="value">
                                @if($order->customer_id)
                                    {{ $order->customer->first_name }} {{ $order->customer->last_name }}
                                @else
                                    {{ $order->guest_first_name ? trim($order->guest_first_name . ' ' . $order->guest_last_name) : $order->guest_name }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <form action="{{ url('feedback/' . $order->order_number) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fb_field">
                                    <div class="fb_label"><i class="fa-solid fa-user"></i> Your Name <span class="req">*</span></div>
                                    <input type="text" class="fb_input" name="guest_name" required
                                        value="{{ $order->customer_id ? ($order->customer->first_name . ' ' . $order->customer->last_name) : ($order->guest_first_name ? trim($order->guest_first_name . ' ' . $order->guest_last_name) : $order->guest_name) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fb_field">
                                    <div class="fb_label"><i class="fa-solid fa-envelope"></i> Email <span class="req">*</span></div>
                                    <input type="email" class="fb_input" name="guest_email" required
                                        value="{{ $order->customer_id ? $order->customer->email : $order->guest_email }}">
                                </div>
                            </div>
                        </div>

                        <div class="fb_field">
                            <div class="fb_label"><i class="fa-solid fa-tag"></i> Feedback Category <span class="req">*</span></div>
                            <select class="fb_select" name="category" required>
                                <option value="">Select a category</option>
                                <option value="Room Cleanliness">Room Cleanliness</option>
                                <option value="Staff Service">Staff Service</option>
                                <option value="Amenities">Amenities</option>
                                <option value="Food & Beverages">Food & Beverages</option>
                                <option value="Check-in / Check-out Process">Check-in / Check-out Process</option>
                                <option value="Value for Money">Value for Money</option>
                                <option value="General Suggestion">General Suggestion</option>
                                <option value="Complaint">Complaint</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="fb_field">
                            <div class="fb_label"><i class="fa-solid fa-message"></i> Your Feedback <span class="req">*</span></div>
                            <textarea class="fb_textarea" name="message" required maxlength="500"
                                      id="fb-message"
                                      placeholder="Please share your experience, suggestions, or any concerns...">{{ old('message') }}</textarea>
                            <div class="fb_hint">
                                <span><i class="fa-solid fa-triangle-exclamation"></i> Please do not include payment or credit card information.</span>
                                <span id="fb-count">0 / 500</span>
                            </div>
                        </div>

                        <div class="fb_field">
                            <div class="fb_label"><i class="fa-solid fa-camera"></i> Attach Screenshot <span style="font-size:11px; color:#94a3b8; font-weight:500;">(Optional)</span></div>
                            <input type="file" class="fb_input" name="screenshot" accept="image/*,.pdf" style="padding:10px 14px;">
                        </div>

                        <div class="fb_field">
                            <div class="fb_checkbox_row">
                                <input type="checkbox" id="contact_me" name="contact_me" value="1">
                                <label for="contact_me">I would like Mountain View Motel to contact me regarding my feedback</label>
                            </div>
                        </div>

                        <button type="submit" class="fb_submit_btn">
                            <i class="fa-solid fa-paper-plane"></i> Submit Feedback
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var box = document.getElementById('fb-message');
    var count = document.getElementById('fb-count');
    if (!box || !count) return;

    function update() { count.textContent = box.value.length + ' / 500'; }
    box.addEventListener('input', update);
    update();
});
</script>

@include('front.inc.footer')
