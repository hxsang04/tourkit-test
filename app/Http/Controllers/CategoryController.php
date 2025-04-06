<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Log;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('posts')->paginate(10);


        return view('categories.list', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.'
        ]);

        try {
            Category::create([
                'title' => $request->title
            ]);

            toastr()->success('Thêm danh mục thành công.');
            return redirect()->route('categories.index');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            toastr()->error('Có lỗi xảy ra, vui lòng thử lại.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.'
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->title = $request->title;
            $category->save();

            toastr()->success('Sửa danh mục thành công.');
            return redirect()->route('categories.index');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            toastr()->error('Có lỗi xảy ra, vui lòng thử lại.');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        toastr()->success('Xóa danh mục thành công.');
        return back();
    }
}
