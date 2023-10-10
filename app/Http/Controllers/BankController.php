<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index()
    {
        $customerID = Auth::guard('customer')->user()->id;
        $data = Customer::where('id', $customerID)->first();
        return view('Customer.bank', compact('data'));
    }

    public function bank(Request $request)
    {
        $customerID = Auth::guard('customer')->user()->id;
        $data = Customer::find($customerID);
        $data->amount = $request->soTien;
        $data->update();
        toastr()->success("Đã Nạp Tiền Thành Công");
        return redirect('/user/bank');
    }
}
