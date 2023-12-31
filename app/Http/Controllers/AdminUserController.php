<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AdminUserLogin;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function loginAdmin()
    {
        return  view('login');
    }

    public function login(AdminUserLogin $request)
    {
        $data = $request->only('email' , 'password');
        $checkUserLogin = Auth::guard('users')->attempt($data);
        if($checkUserLogin){
            $user = Auth::guard('users')->user();
            if($user->is_open == 1){
                toastr()->success('Đã Đăng Nhập Thành Công');
                return redirect('/admin/home');
            }else{
                toastr()->warning('Tài khoản hiện đang tạm khoá');
                return redirect('/admin/login');
            }
        }else{
            toastr()->error("Email hoặc mật khẩu không chính xác");
            return redirect('/admin/login');
        }
    }

    public function logout()
    {
        Auth::guard('useradmin')->logout();
        return redirect('/admin/login');
    }

    public function home()
    {
        return view('pages.index');
    }
}
