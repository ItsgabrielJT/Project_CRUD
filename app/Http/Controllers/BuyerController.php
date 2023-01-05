<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyerStoreRequest;
use App\Models\Buyer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $buyers = DB::table('buyers')
            ->select('id', 'ci', 'nombre', 'email', 'created_at')
            ->where('nombre', 'LIKE', '%'.$texto.'%')
            ->orWhere('ci', 'LIKE', '%'.$texto.'%')
            ->orderBy('nombre', 'asc')
            ->paginate(10);
        return view('buyers.index', compact('buyers', 'texto')); 
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
