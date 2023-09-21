<?php

namespace App\Http\Controllers;


use App\Http\Requests\Client\News\CreateNewsRequest;
use App\Http\Requests\Client\News\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $data = News::join('users', 'news.user_id', 'users.id')
            ->select('news.*', 'users.first_name as firstname', 'users.last_name as lastname')
            ->get();
        // dd($data);

        return view('pages.news.index', compact('data'));
    }

    public function create()
    {
        $newsCategory = NewsCategory::all();
        // dd($newsCategory);
        return view('pages.news.create', compact('newsCategory'));
    }

    public function store(CreateNewsRequest $request)
    {
        $user = Auth::guard('users')->user();
        $data = $request->all();
        $data['user_id']    = $user->id;
        News::create($data);
        toastr()->success('Đã thêm mới dữ liệu thành công');
        return redirect('/admin/news/create');
    }

    public function edit($id)
    {
        $newsCategory = NewsCategory::all();
        $data = News::find($id);
        return view('pages.news.edit', compact(['data', 'newsCategory']));
    }

    public function update(UpdateNewsRequest $request)
    {
        $data = News::find($request->id);
        $data->update($request->all());
        toastr()->success('Đã cập nhật dữ liệu thành công');
        return redirect('/admin/news');
    }

    public function destroy($id)
    {
        $data = News::find($id);
        $data->delete();
        toastr()->success("Đã Xoá Thành Công");
        return redirect('/admin/news');
    }
}
