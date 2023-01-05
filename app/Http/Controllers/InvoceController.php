<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Mail\InvoceMail;
use App\Models\Buyer;
use App\Models\Invoce;
use App\Models\InvoceDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoces = Invoce::with('buyer')->paginate(3);
        return view('invoces.index', compact('invoces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoce = new Invoce();
        $buyers = Buyer::all();
        return view('invoces.create', compact('invoce', 'buyers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceStoreRequest $request)
    {
        $invoce = Invoce::create($request->validated());
        return redirect()->route('invoce.add_products', ['invoce'=>$invoce->id])
            ->with(['status'=>'Success', 'color' => 'green', 'message'=>'Item Added Sucessfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoce  $invoce
     * @return \Illuminate\Http\Response
     */
    public function show(Invoce $invoce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoce  $invoce
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoce $invoce)
    {
        $buyers = Buyer::all();
        return view('invoces.create', compact('invoce', 'buyers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoce  $invoce
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceStoreRequest $request, Invoce $invoce)
    {
        $invoce->fill($request->validate());
        $invoce->save();
        return redirect()->route('invoce.index')->with(['status'=>'Success', 'color' => 'green', 'message'=>'Invoice Created Sucessfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoce  $invoce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoce $invoce)
    {
        try {
            $invoce->delete();
            $result = ['status'=>'Success', 'color' => 'green','message'=>'Invoice Deleted Sucessfully'];
        } catch(Exception $e) {
            $result = ['status'=>'Success', 'color' => 'red','message'=>'Invoice cannot be delete'];
        } 
        return redirect()->route('invoce.index')->with($result);
    }

    public function completeSend(Request $request, Invoce $invoce) {
        $details = InvoceDetail::with('product')
            ->where('invoce_id', $invoce->id)
            ->get();

        try {
            Mail::to($invoce->buyer->email)
                ->queue(new InvoceMail($invoce, $details));
            $result = ['status' => 'success', 'color' => 'green', 'message' => 'Mail sent successfully'];
        } catch (\Exception $e) {
            $result = ['status' => 'success', 'color' => 'green', 'message' => $e->getMessage()];
        }

        $invoce->estatus = 'complete';
        $invoce->save();

        return redirect()->route('invoce.index')->with($result);
    }
}
