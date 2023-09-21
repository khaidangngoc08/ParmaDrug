<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\Product\CreateProductRequest;
use App\Http\Requests\Client\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::orderByDesc('id')->get();
        toastr()->info('Đã load data...');
        return view('pages.product.index', compact('data'));
    }

    public function create()
    {
        $product_category = ProductCategory::all();
        return view('pages.product.create', compact('product_category'));
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->all();
        Product::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect('/admin/product/create');
    }

    public function edit($id)
    {
        $data = Product::find($id);
        $product_category = ProductCategory::all();
        return view('pages.product.edit', compact('data' , 'product_category'));

    }

    public function update(UpdateProductRequest $request)
    {
        $data = Product::find($request->id);
        $data->update($request->all());
        toastr()->success('Đã cập nhật dữ liệu thành công');
        return redirect('/admin/product');
    }

    public function destroy($id)
    {
        $data = Product::find($id);
        if($data){
            $data->delete();
            toastr()->success("Đã Xoá Thành công");
            return redirect('/admin/product');
        }else{
            toastr()->error("Đã Có Lỗi Xảy Ra !!!");
        }

    }
}
