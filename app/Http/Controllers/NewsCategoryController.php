<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\NewsCategory\CreateNewsCategoryRequest;
use App\Http\Requests\Client\NewsCategory\UpdateNewsCategoryRequest;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{


    public function list()
    {
        $data = NewsCategory::all();

        return view('pages.newsCategory.list', compact('data'));
    }

    public function create()
    {
        $data = NewsCategory::all();

        toastr()->info('Đã load data...');

        return view('pages.newsCategory.create', compact('data'));
    }

    public function store(CreateNewsCategoryRequest $request)
    {
        $user = Auth::guard('users')->user();
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['user_id']    = $user->id;
        NewsCategory::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect('/admin/news-category/create');
    }

    public function edit($id)
    {
        $data = NewsCategory::find($id);

        return view('pages.newsCategory.edit', compact('data'));
    }

    public function update(UpdateNewsCategoryRequest $request)
    {
        $data = NewsCategory::find($request->id);
        $data->update($request->all());
        toastr()->success('Đã cập nhật dữ liệu thành công');
        return redirect('/admin/news-category/create');
    }


    public function destroy($id)
    {
        $data = NewsCategory::find($id);
        $data->delete();
        toastr()->success('Đã xóa dữ liệu thành công');
        return redirect('/admin/news-category/list');
    }
}
