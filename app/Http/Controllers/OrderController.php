<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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

    public function timber_orders(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
       $orders = Order::query()
                        ->with(['user', 'design'])
                        ->whereHas('timber_provider', function ($q){
                            $q->where('user_id', Auth::id());
                        })->orderByDesc('id')
                        ->paginate();

       return view('timber_supply.orders', compact('orders'));
    }

    public function cnc_orders(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
       $orders = Order::query()
                        ->with(['user', 'design'])
                        ->whereHas('cnc_provider', function ($q){
                            $q->where('user_id', Auth::id());
                        })->orderByDesc('id')
                        ->paginate();

       return view('cnc_supply.orders', compact('orders'));
    }
}
