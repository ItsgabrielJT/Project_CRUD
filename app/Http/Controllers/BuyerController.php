<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyerStoreRequest;
use App\Models\Buyer;
use Exception;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::paginate(10); // mostrara solo dos elemtnos de la tabla
        return view('buyers.index', compact('buyers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buyer = new Buyer();
        return view('buyers.create', compact('buyer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuyerStoreRequest $request)
    {
        Buyer::create($request->validated());
        return redirect()->route('buyer.index')->with(['status'=>'Success', 'color' => 'green', 'message'=>'Buyer Registred Sucessfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer)
    {
        return view('buyers.create', compact('buyer'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(BuyerStoreRequest $request, Buyer $buyer)
    {
        $buyer->fill($request->validate());
        $buyer->save();    
        return redirect()->route('buyer.index')->with(['status'=>'Success', 'color' => 'green', 'message'=>'Buyer Updated Sucessfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        try {
            $buyer->delete();
            $result = ['status'=>'Success', 'color' => 'green','message'=>'Buyer Deleted Sucessfully'];
        } catch(Exception $e) {
            $result = ['status'=>'Success', 'color' => 'red','message'=>'Buyer cannot be delete'];
        } 
        return redirect()->route('buyer.index')->with($result);
    }
}
