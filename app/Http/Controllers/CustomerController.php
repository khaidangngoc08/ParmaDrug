<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\Customer\CreateCustomerRequest;
use App\Http\Requests\Client\Customer\UpdateCustomerRequest;
use App\Http\Requests\Client\Product\SearchProductRequest;
use App\Http\Requests\rePassword;
use App\Http\Requests\updateProfile;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegiserRequest;
use App\Models\BillDetails;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\News;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
{

    public function create()
    {
        $data = Customer::paginate(10);
        toastr()->info('Đã load data...');
        return view('pages.customer.create', compact('data'));
    }

    public function list_customer()
    {
        $data = Customer::paginate(10);
        toastr()->info('Đã load data...');
        return view('pages.customer.list_customer', compact('data'));
    }



    public function store(CreateCustomerRequest $request)
    {
        $data = $request->all();
        Customer::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect('/admin/customer/create');
    }



    public function edit($id)
    {
        $data = Customer::find($id);
        return view('pages.customer.edit', compact('data'));
    }

    public function update(UpdateCustomerRequest $request)
    {
        $data = Customer::find($request->id);
        $data->update($request->all());
        toastr()->success('Đã cập nhật dữ liệu thành công');
        return redirect('/customer/create');
    }

    public function destroy($id)
    {
        $data = Customer::find($id);
        $data->delete();
        toastr()->success('Đã xoá khách hàng thành công');
        return redirect('/admin/customer/list');
    }

    public function homePage()
    {
        $data = Product::join('product_categories', 'products.product_category_id', 'product_categories.id')
            ->select('products.*', 'product_categories.name as categori_name')
            ->get();
        $new = News::all();
        return view('client.Shared.product', compact('data', 'new'));
    }

    public function viewregister()
    {
        return view('Customer.customer_register');
    }

    public function viewLogin()
    {
        return view('Customer.customer_login');
    }


    public function register(RegiserRequest $request)
    {
        $data =  $request->all();
        Customer::create($data);
        toastr()->success("Bạn đã đăng kí thành công");
        return redirect('/login');
    }

    public function Login(LoginRequest $request)
    {
        $data =  $request->only('email', 'password');
        $checklogin = Auth::guard('customer')->attempt($data);
        if ($checklogin == true) {
            $user = Auth::guard('customer')->user();
            if ($user->is_active == 1) {
                $count = Bill::select(DB::raw('count(id) as total'))
                    ->groupBy('customer_id')->first();
                if (!empty($count)) {
                    $maHoaDon = Bill::where('customer_id', $user->id)->get();
                    foreach ($maHoaDon as $key => $value) {
                        $value->delete();
                    }
                    $data['hash']           = Str::uuid();
                    $data['customer_id']    = $user->id;
                    Bill::create($data);
                } else {
                    $data['hash']           = Str::uuid();
                    $data['customer_id']    = $user->id;
                    Bill::create($data);
                }
                toastr()->success('Đã Đăng Nhập Thành Công');
                return redirect('/');
            } else {
                toastr()->warning('Tài khoản hiện đang tạm khoá');
                return redirect('/login');
            }
        } else {
            toastr()->error("Email hoặc mật khẩu không chính xác");
            return redirect('/login');
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }

    public function profile($id)
    {
        $data = Customer::find($id);
        return view('client.profile.index', compact('data'));
    }

    public function updateProfile(updateProfile $request)
    {
        $data = Customer::find($request->id);
        $all = $request->all();
        $data->update($all);
        toastr()->success("Đã Update thông tin thành công");
        return redirect("/user/profile/" . $request->id);
    }

    public function viewrePassword()
    {
        return view('client.profile.reset');
    }

    public function re_Password(rePassword $request)
    {
        $data = $request->only('password');
        $data['email'] = Auth::guard('customer')->user()->email;
        $checklogin = Auth::guard('customer')->attempt($data);
        if ($checklogin) {
            $data = Customer::find(Auth::guard('customer')->user()->id);
            $data['password'] =  $request->new_password;
            $data->update();
            toastr()->success("Thay đổi mật khẩu thành công");
            return redirect('/user/reset-password');
        } else {
            toastr()->error("Mật khẩu nhập không chính xác");
            return redirect('/user/reset-password');
        }
    }

    public function index()
    {
        $data = Product::all();
        return view('client.product.index', compact('data'));
    }

    public function search(SearchProductRequest $request)
    {
        $search = $request->search;
        $data = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('content', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')
            ->orWhere('product_category_id', 'like', '%' . $search . '%')
            ->get();

        return view('client.product.index', compact('data'));
    }
}
