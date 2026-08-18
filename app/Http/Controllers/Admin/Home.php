<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function store_founder(Request $request, $id) {
        return redirect()->back()->with('success', 'Saved');
    }
    public function video(Request $request) {
        return redirect()->back()->with('success', 'Saved');
    }
    public function post_team(Request $request) {
        return redirect()->back()->with('success', 'Saved');
    }
    public function update_team(Request $request, $id) {
        return redirect()->back()->with('success', 'Saved');
    }
    public function post_service(Request $request) {
        return redirect()->back()->with('success', 'Saved');
    }
    public function update_service(Request $request, $id) {
        return redirect()->back()->with('success', 'Saved');
    }
}
