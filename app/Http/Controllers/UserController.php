<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $data = User::orderByDesc('created_at')->get();
        return view('pages.user.index', compact("data"));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function loginAdmin()
    {
        return view('login');
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->all();
        $data["is_master"] = false;
        $data["token"] = $request->_token;
        User::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect('/admin/user/create');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only(['email', 'password']);
        $user = Auth::guard('user')->attempt($data);
        if ($user) {
            $user = Auth::guard('user')->user();
            if ($user->is_master) {
                return redirect('');
            } else if ($user->is_admin) {
                return redirect('');
            } else {
                return redirect('');
            }
        } else {
            toastr()->error('Tài khoản hoặc mật khẩu không chính xác');
            return redirect('/');
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('pages.user.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = User::find($request->id);
        $data->update($request->all());
        toastr()->success('Đã cập nhật dữ liệu thành công');
        return redirect('/user');
    }

    public function destroy($id)
    {

        $data = User::find($id);
        $data->delete();
        toastr()->success("Đã Xoá Thành Công");
        return redirect('/admin/user');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
    }
}
