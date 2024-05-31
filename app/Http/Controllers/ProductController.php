<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('products','sections'));

//        $products = DB::table('products')
//            ->select('products.*', 'sections.section_name as section_name')
//            ->join('sections', 'products.section_id', '=', 'sections.id')
//            ->get();
//
//        return view('products.products', compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Product::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $id = Section::where('section_name', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->pro_id);

        $Products->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(Request $request, Product $product)
//    {
//        //
//
//        $product = Product::findOrFail($request->pro_id);
//        $product->delete();
//        session()->flash('delete', 'تم حذف المنتج بنجاح');
//        return back();
//    }

    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->pro_id);
        $product->delete();

        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }

}
