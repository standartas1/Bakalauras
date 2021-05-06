<?php

namespace App\Http\Controllers;

use App\Client;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
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
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }

        $logs = Log::all();

        return view('log.index', compact('logs'));
    }
}
