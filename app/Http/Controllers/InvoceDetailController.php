<?php

namespace App\Http\Controllers;

use App\Models\Invoce;
use App\Models\InvoceDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invoce $invoce)
    {
        $products = Product::all();
        $details = InvoceDetail::where('invoce_id', $invoce->id)->get();
        return view('invoces.add_products', compact('products', 'invoce', 'details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'invoce_id' => 'required',
            'product_id' => 'required',
            'cantidad' => 'required'
        ]);

        $data = $request->only(['product_id', 'invoce_id', 'precio', 'cantidad']);

        if ($data['precio'] !== "") {
            $data['precio'] = Product::find($data['product_id'])->precio;
            
        }

        $data['product_total'] = $data['precio'] * $data['cantidad'];
        
        InvoceDetail::create($data);

        return redirect()->route('invoce.add_products', ['invoce' => $data['invoce_id']])->with(['status' => 'Success', 'color' => 'green', 'message' => 'Buyer created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoceDetail  $invoceDetail
     * @return \Illuminate\Http\Response
     */
    public function show(InvoceDetail $invoceDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoceDetail  $invoceDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoceDetail $invoceDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoceDetail  $invoceDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoceDetail $invoceDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoceDetail  $invoceDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoceDetail $invoceDetail)
    {
        //
    }
}
