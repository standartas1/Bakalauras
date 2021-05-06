<?php

namespace App\Http\Controllers;

use App\Client;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $client_id = 2; // Mech City
        if (!empty($request->client_id)) {
            $client_id = (int) $request->client_id;
        }
        $orders = Order::where('client_id', $client_id)->orderBy('created_at', 'asc')->get();
        $prices = [];
        $prices[0] = 0;
        $prices[1] = 0;
        $prices[2] = 0;
        $idPoints = [];
        $profitPoints = [];
        $client = Client::find($client_id);
        $allOrders = Order::all();
        $allClients = Client::all();
        $clientNames = [];
        $profitTotals = [];
        foreach ($allClients as $cli) {
            $clientNames[] = $cli->name;
            $filtered = $allOrders->where('client_id', '=', $cli->id);
            $itemProfit = 0;
            foreach ($filtered as $item){
                $itemProfit += $item->profit;
            }
            $profitTotals[] = $itemProfit;
        }
        foreach ($orders as $order) {
            $prices[0] = $prices[0] + $order->profit;
            $prices[1] = $prices[1] + $order->price_self;
            $prices[2] = $prices[2] + $order->price;
            $idPoints[] = 'Order: '. $order->id;
            $profitPoints[] = $order->profit;
        }

        return view('graphs', compact('prices', 'idPoints', 'profitPoints', 'client', 'clientNames', 'profitTotals', 'allClients'));
    }
}
