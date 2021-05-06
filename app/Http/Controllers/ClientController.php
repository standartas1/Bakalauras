<?php

namespace App\Http\Controllers;

use App\Client;
use App\Log;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role_id === 1) {
            return redirect()->route('orders.index');
        }
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role_id === 1) {
            return redirect()->route('orders.index');
        }
        $validatedData = $request->validate([
            'name' => 'required|unique:clients|max:255',
        ]);
        $create = Client::create($validatedData);

        Log::createLog('client', Auth::user()->username . ' created client, id: ' . $create->id);

        return redirect('/clients')->with('success', 'Client was successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role_id === 1) {
            return redirect()->route('orders.index');
        }
        $client = Client::findOrFail($id);

        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role_id === 1) {
            return redirect()->route('orders.index');
        }
        $validatedData = $request->validate([
            'name' => 'required|unique:clients|max:255',
        ]);
        Client::whereId($id)->update($validatedData);

        Log::createLog('client', Auth::user()->username . ' updated client, id: ' . $id);

        return redirect('/clients')->with('success', 'Client was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id === 1) {
            return redirect()->route('orders.index');
        }
        $client = Client::findOrFail($id);
        $orders = Order::where('client_id', $id)->get();
        if (!empty($orders) && count($orders) > 0) {
            return redirect()->back()->withErrors(['id'=>'Can not delete client with orders']);
        }
        $client->delete();

        Log::createLog('client',  Auth::user()->username . ' deleted client, id: ' . $id);

        return redirect('/clients')->with('success', 'Client was successfully deleted');
    }
}
