<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    /**
     * Show the feedback form for a specific order.
     */
    public function show($orderNumber)
    {
        $order = Order::with(['customer', 'items'])->where('order_number', $orderNumber)->firstOrFail();

        return view('front.feedback', compact('order'));
    }

    /**
     * Store the submitted feedback.
     */
    public function store(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'category' => 'required|string|max:255',
            'message' => 'required|string',
            'screenshot' => 'nullable|file|max:5120',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = time() . '_feedback_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/feedbacks/'), $filename);
            $screenshotPath = 'storage/feedbacks/' . $filename;
        }

        Feedback::create([
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'guest_name' => $request->input('guest_name'),
            'guest_email' => $request->input('guest_email'),
            'category' => $request->input('category'),
            'message' => $request->input('message'),
            'screenshot_path' => $screenshotPath,
            'contact_me' => $request->has('contact_me') ? true : false,
        ]);

        return redirect()->back()->with('feedback_success', true);
    }
}
