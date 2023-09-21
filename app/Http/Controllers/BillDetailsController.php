<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\BillDetails\CreateBillDetailsRequest;
use App\Http\Requests\Client\BillDetails\UpdateBillDetailsRequest;
use App\Http\Requests\gioHang;
use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\Product;
use Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class BillDetailsController extends Controller
{

    public function create()
    {
        $bill = Bill::join('customers', 'bills.customer_id', 'customers.id')
            ->select('bills.*', 'customers.name as nameCustomer')->get();
        $product = Product::all();

        $data = BillDetails::join('products', 'bill_details.product_id', 'products.id')
            ->join('bills',  'bill_details.bill_id', 'bills.id')
            ->join('customers', 'bills.customer_id', 'customers.id')
            ->select('bill_details.*', 'products.name as nameProduct', 'bills.hash as maHoaDon', 'customers.name as nameCustomer_bill')
            ->get();
        toastr()->info('Đã load data...');

        return view('pages.billDetails.create', compact('data', 'bill', 'product'));
    }

    public function list_bill()
    {
        $bill = Bill::all();
        $product = Product::all();

        $data = BillDetails::join('products', 'bill_details.product_id', 'products.id')
            ->join('bills',  'bill_details.bill_id', 'bills.id')
            ->join('customers', 'bills.customer_id', 'customers.id')
            ->select('bill_details.*', 'products.name as nameProduct', 'bills.hash as maHoaDon', 'customers.name as nameCustomer_bill')
            ->get();
        toastr()->info('Đã load data...');

        return view('pages.billDetails.list', compact('data', 'bill', 'product'));
    }

    public function store(CreateBillDetailsRequest $request)
    {
        $data = $request->all();

        $product = Product::find($request->product_id);
        $data['price']  = $product->price;
        BillDetails::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect()->back();
    }

    public function edit($id)
    {
        $data = BillDetails::find($id);
        return view('pages.billDetails.edit', compact(['data']));
    }

    public function update(UpdateBillDetailsRequest $request)
    {
        $data = BillDetails::find($request->id);
        $data->update($request->all());
        toastr()->success('Đã cập nhật dữ liệu thành công');
        return redirect('/admin/bill-details/list_bill');
    }

    public function destroy($id)
    {
        $data = BillDetails::find($id);
        $data->delete();
        toastr()->success("Đã Xoá Thành Công");
        return redirect('/admin/bill-details/list_bill');
    }

    public function addBill(gioHang $request)
    {
        $data = Product::find($request->id);
        $customerID = Auth::guard('customer')->user()->id;
        $bill_detail['bill_id']         = $customerID;
        $bill_detail['product_id']      = $request->id;
        $bill_detail['price']           = $data->price;
        $bill_detail['quantity']        = $request->quantity;
        BillDetails::create($bill_detail);
        toastr()->success("Đã thêm vào giỏ hàng");

        return redirect('/user/product/detail/' . $request->id);
    }

    public function addBill2(gioHang $request)
    {
        $data = Product::find($request->id);
        $customerID = Auth::guard('customer')->user()->id;
        $bill_detail['bill_id']         = $customerID;
        $bill_detail['product_id']      = $request->id;
        $bill_detail['price']           = $data->price;
        $bill_detail['quantity']        = $request->quantity;
        BillDetails::create($bill_detail);
        toastr()->success("Đã thêm vào giỏ hàng");
        return redirect('/user/product');
    }
}
