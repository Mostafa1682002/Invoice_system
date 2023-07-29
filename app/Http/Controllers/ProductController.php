<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::get();
        $products = Product::get();
        return view('products.products', ['products' => $products, 'sections' => $sections]);
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
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        if ($product) {
            return redirect()->back()->with('success_products', 'تم انشاء المنتج بنجاح');
        }
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
        $id_product = $request->id;
        $request->validate([
            'product_name' => 'required|unique:sections,section_name,' . $id_product,
            'section_id' => 'required',
            'description' => 'required',
        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'هذا الاسم موجود مسبقا',
            'section_id.required' => 'يرجي اختيار اسم القسم',
            'description.required' => 'هذا الحقل مطلوب',
        ]);
        $product_edite = Product::find($id_product);

        if ($product_edite) {
            $product_edite->update($request->only(['product_name', 'description', 'section_id']));
            return redirect()->back()->with('success_products', 'تم تعديل المنتج بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product_delete = Product::find($request->id);
        if ($product_delete) {
            $product_delete->delete();
            return redirect()->back()->with('success_products', 'تم حذف المنتج بنجاح');
        }
    }
}
