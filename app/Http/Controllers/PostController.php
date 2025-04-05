<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('posts.list', compact('categories'));
    }

    public function getData(Request $request)
    {
        $keyword = $request->get('keyword');
        $category_id = $request->get('category_id');
        $start = $request->get('start', 0); 
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column') ?? 'id';
        $orderDir = $request->get('order_dir') ?? 'asc';
    
        $query = Post::with('categories')
            ->orderBy($orderColumn, $orderDir);
    
        if ($keyword) {
            $query->where('title', 'like', "%$keyword%");
        }
    
        if ($category_id) {
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }
    
        $totaFilter = $query->count();
    
        $posts = $query->skip($start)->take($length)->get();
        
        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => Post::count(),
            'recordsFiltered' => $totaFilter,
            'data' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id|integer',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'content.required' => 'Nội dung là bắt buộc.',
            'category_ids.required' => 'Danh mục là bắt buộc.'
        ]);
        try {
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content
            ]);

            $post->categories()->attach($request->category_ids);

            toastr()->success('Thêm bài viết thành công.');
            return redirect()->route('posts.index');

        } catch (\Exception $e) {
            return back();
            Log::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::all();
        $post = Post::findOrFail($id);
        $categoryPost = $post->categories->pluck('id')->toArray();
        return view('posts.edit', compact('categories', 'post', 'categoryPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_ids' => 'array|required',
            'category_ids.*' => 'exists:categories,id|integer',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'content.required' => 'Nội dung là bắt buộc.',
            'category_ids.required' => 'Danh mục là bắt buộc.'
        ]);
    
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
    
        $post->categories()->sync($request->category_ids);
        toastr()->success('Cập nhật bài viết thành công.');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        toastr()->success('Xóa bài viết thành công.');
        return back();
    }
}
