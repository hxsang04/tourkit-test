@extends('layout')

@section('content')
<style>
    #categories {
        height: 200px;
    }
</style>

<div class="container mt-4">
    <h1>Chỉnh sửa bài viết</h1>
    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @csrf
z        <div class="form-group mt-3">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}">
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="content">Nội dung</label>
            <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="categories">Danh mục <span class="text-danger">(giữ Ctrl để chọn nhiều)</span></label>
            <select name="category_ids[]" id="categories" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('category_ids', $categoryPost)) ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
            @error('category_ids')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>
@endsection
