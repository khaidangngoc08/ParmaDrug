<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\Bill\CreateBillRequest;
use App\Http\Requests\Client\Bill\UpdateBillRequest;
use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\Bills;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function create()
    {
        $bill = Bill::paginate(10);

        $customer = Customer::all();

        return view('pages.bill.create', compact('bill', 'customer'));
    }

    public function store(CreateBillRequest $request)
    {
        $user = Auth::guard('users')->user();
        // dd($user->id);
        $data = $request->all();
        $data['hash']   = Str::uuid();
        $data['user_id']    = $user->id;
        // dd($data);
        Bill::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect('/admin/bill/create');
    }


    public function edit($id)
    {
        $data = Bill::find($id);

        return view('pages.bill.update', compact('data'));
    }

    public function update(UpdateBillRequest $request)
    {
        $data = Bill::find($request->id);

        $data->update($request->all());

        toastr()->success('Đã cập nhật dữ liệu thành công');

        return redirect('/admin/bill/create');
    }

    public function destroy($id)
    {
        $data = Bill::find($id);

        $data->delete();

        return redirect('/admin/bill/list');
    }

    public function list()
    {
        $data = Bill::all();
        return view('pages.bill.list_bill', compact('data'));
    }

    public function gioHang()
    {
        $customerID = Auth::guard('customer')->user()->id;
        $data = BillDetails::join('bills', 'bill_details.bill_id', 'bills.customer_id')
            ->join('customers', 'bill_details.bill_id', 'customers.id')
            ->join('products', 'bill_details.product_id', 'products.id')
            ->select('bill_details.*', 'bills.id as idHoaDon', 'customers.name as nameCus', 'products.name as nameProduct', 'products.avatar as avatarProduct')
            ->where('customer_id', $customerID)->get();
        $customer_total  = Customer::find($customerID);
        $count = BillDetails::where('bill_id', $customerID)
            ->select(DB::raw('sum(quantity) as total'))
            ->get();
        $total_money = 0;
        foreach ($data as $key => $value) {
            $total_money = $total_money + ($value->price * $value->quantity);
        }
        $sum_price = $total_money - $total_money * 0.05;
        return view('client.gioHang.index', compact('data', 'customer_total', 'count', 'total_money', 'sum_price'));
    }

    public function deleteDonHang($id)
    {
        $data = BillDetails::find($id);
        if ($data) {
            $data->delete();
            toastr()->success("Đã Xoá Sản Phẩm Khỏi Giỏ Hàng");
            return redirect('/user/gio-hang');
        } else {
            toastr()->error("Đã Có Lỗi Xảy Ra");
        }
    }

    public function thanhToan(Request $request)
    {
        $SoDu       = $request->soDu;
        $TongTien   = $request->thanhToan;
        if ($SoDu < $TongTien) {
            toastr()->warning("Số Tiền Trong Tài Khoản Của Bạn Không Đủ");
            return redirect('/user/gio-hang');
        } else {

            $ID_Cus = Auth::guard('customer')->user()->id;

            $SoDu = $SoDu - $TongTien;
            $data = Customer::find(Auth::guard('customer')->user()->id);
            $data['amount'] = $SoDu;
            $data->update();

            $bill = BillDetails::where('bill_id', $ID_Cus)->get();
            foreach ($bill as $key => $value) {
                $dataBill = BillDetails::find($value->id);
                $dataBill->delete();
            }
            $dataHoaDon = Bill::where('customer_id', $ID_Cus)->first();
            $deleteHoaDon = Bill::find($dataHoaDon->id);
            $deleteHoaDon->delete();
            toastr()->success('Đã thanh toán thành công');
            $data_total['hash']           = Str::uuid();
            $data_total['customer_id']    = $ID_Cus;

            Bill::create($data_total);
            return redirect('/user/gio-hang');
        }
    }

    // public function coutDonHang()
    // {
    //     $Bill_id = Auth::guard('customer')->user()->id;

    //     $count = BillDetails::where('bill_id' , $Bill_id )
    //                 ->select(DB::raw('count(id) as total'))
    //                 ->get();
    //     dd($count->toArray());
    //     return view('master-homepage', compact('count'));
    // }
}
