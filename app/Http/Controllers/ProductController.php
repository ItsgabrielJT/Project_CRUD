<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $products = DB::table('products')
            ->select('id', 'nombre', 'precio', 'image', 'created_at')
            ->where('nombre', 'LIKE', '%'.$texto.'%')
            ->orWhere('precio', 'LIKE', '%'.$texto.'%')
            ->orderBy('precio', 'asc')
            ->paginate(10);
        return view('products.index', compact('products', 'texto')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        
        return view('products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->all();
        if($request->has('image')) {
            $img_path = $request->file('image')->store('medias');
            $data['image'] = $img_path;
        }
        Product::create($data);
        return redirect()->route('product.index')->with(['status'=>'Success', 'color' => 'green', 'message'=>'Product Created Sucessfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.create', compact('product'));         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $data = $request->all();
        if($request->has('image')) {
            Storage::delete($product->image);// Nos ayuda a no repetir el recurso
            $img_path = $request->file('image')->store('medias');
            $data['image'] = $img_path;
        }
        $product->fill($data); // LLena el objt con la nueva data
        $product->save();
        return redirect()->route('product.index')->with(['status'=>'Success', 'color' => 'blue', 'message'=>'Product Update Sucessfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Cuando tenemos relaciones con tabals teemos que colcar un try para evitar errores
        try {
            $product->delete();
            $result = ['status'=>'Success', 'color' => 'green','message'=>'Product Deleted Sucessfully'];
        } catch(Exception $e) {
            $result = ['status'=>'Success', 'color' => 'red','message'=>'Product cannot be delete'];
        }
        return redirect()->route('product.index')->with($result);
    }
}
