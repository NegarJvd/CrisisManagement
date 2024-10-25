<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $data = $request->only(['design_id', 'timber_id', 'cnc_id']);
        $data['user_id'] = Auth::id();

        Order::create($data);

        return redirect()->back()->with('success', 'Order submitted successfully!');
    }
}
