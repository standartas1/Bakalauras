<?php

namespace App\Http\Controllers;

use App\Client;
use App\File;
use App\Log;
use App\Order;
use App\Subtype;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::with('client', 'type');
        $typeSelected = null;
        $subtypeSelected = null;
        if (!empty($request->input('type_id')) && !empty(Type::find($request->input('type_id')))) {
            $query = $query->where('type_id', $request->input('type_id'));
            $typeSelected = $request->input('type_id');
            if (!empty($request->input('subtype_id')) && !empty(Subtype::find($request->input('subtype_id'))) && (int)$request->input('type_id') === 1)  {
                $query = $query->where('subtype_id', $request->input('subtype_id'));
                $subtypeSelected = $request->input('subtype_id');
            }
        }
        $orders = $query->get();
        $types = Type::all();
        $subtypes = Subtype::all();

        return view('order.index', compact('orders', 'types', 'subtypes', 'typeSelected', 'subtypeSelected'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientOrders(Request $request, $client_id)
    {
        $query = Order::where('client_id', $client_id)->with('client', 'type');
        $typeSelected = null;
        $subtypeSelected = null;
        if (!empty($request->input('type_id')) && !empty(Type::find($request->input('type_id')))) {
            $query = $query->where('type_id', $request->input('type_id'));
            $typeSelected = $request->input('type_id');
            if (!empty($request->input('subtype_id')) && !empty(Subtype::find($request->input('subtype_id'))) && (int)$request->input('type_id') === 1)  {
                $query = $query->where('subtype_id', $request->input('subtype_id'));
                $subtypeSelected = $request->input('subtype_id');
            }
        }
        $orders = $query->get();
        $types = Type::all();
        $subtypes = Subtype::all();

        return view('order.index', compact('orders', 'types', 'subtypes', 'typeSelected', 'subtypeSelected'));
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
        $types = Type::all();
        $clients = Client::all();
        $subtypes = Subtype::all();
        return view('order.create', compact('types', 'clients', 'subtypes'));
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
            'price' => 'required|between:0,999999.99|numeric',
            'price_self' => 'required|between:0,999999.99|numeric',
            'client_id' => 'required',
            'type_id' => 'required',
            'information' => 'nullable',
            'subtype_id' => 'nullable',
            'file' => 'mimes:pdf,xlx,xlsx|max:2048|sometimes|nullable',
        ]);
//        dd($validatedData);
        if ($validatedData['type_id'] != 1) {
            $validatedData['subtype_id'] = null;
        }
        $validatedData['profit'] = $validatedData['price'] - $validatedData['price_self'];
        if (isset($validatedData['file'])) {
            $originalName = $validatedData['file']->getClientOriginalName();

            $fileName = 'uploads/'.time().'_'.$originalName;

            Storage::disk('local')->put($fileName, file_get_contents($validatedData['file']));

            $fileArray = [
                'name'=>$originalName,
                'location'=>$fileName
            ];
            $file = File::create($fileArray);
            $validatedData['file_id'] = $file->id;
        }

        $create = Order::create($validatedData);

        Log::createLog('order', Auth::user()->username . ' created new order, id: ' . $create->id);

        return redirect('/orders')->with('success', 'Order was successfully created');
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
        $order = Order::find($id);
        $types = Type::all();
        $clients = Client::all();
        $subtypes = Subtype::all();

        return view('order.edit', compact('order', 'types', 'clients', 'subtypes'));
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
            'price' => 'required|between:0,999999.99',
            'price_self' => 'required|between:0,999999.99',
            'client_id' => 'required',
            'type_id' => 'required',
            'information' => 'nullable',
            'subtype_id' => 'nullable',
            'file' => 'mimes:pdf,xlx|max:2048|sometimes|nullable',
        ]);
        $order = Order::find($id);
        if ($validatedData['type_id'] != 1) {
            $validatedData['subtype_id'] = null;
        }
        $validatedData['profit'] = $validatedData['price'] - $validatedData['price_self'];

        if (isset($validatedData['file']) && $validatedData['file']->getClientOriginalName() !== $order->file->name) {
            $originalName = $validatedData['file']->getClientOriginalName();

            $fileName = 'uploads/'.time().'_'.$originalName;

            Storage::disk('local')->put($fileName, file_get_contents($validatedData['file']));

            $fileArray = [
                'name'=>$originalName,
                'location'=>$fileName
            ];
            $file = File::create($fileArray);
            $validatedData['file_id'] = $file->id; // TODO: Delete old file
            $old = File::where('id', $order->file->id)->get();
            Storage::disk('local')->delete($old->location);
            $old->delete();
        }

        $order->update($validatedData);

        Log::createLog('order', Auth::user()->username . ' updated order, id: ' . $id);

        return redirect('/orders')->with('success', 'Order was successfully updated');
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
        if (Auth::user()->id === $id || $id === 1) {
            return redirect()->back()->withErrors(['id'=>'Can not delete user']);
        }
        $order = Order::findOrFail($id);
        $order->delete();

        Log::createLog('order', Auth::user()->username . ' deleted order, id: ' . $id);

        return redirect('/orders')->with('success', 'Order was successfully deleted');
    }

    public function downloadFile($id) {
        if (Auth::user()->role_id === 1) {
            return redirect()->route('orders.index');
        }
        $file = File::find($id);
        return Storage::disk('local')->download($file->location, $file->name);
    }
}
