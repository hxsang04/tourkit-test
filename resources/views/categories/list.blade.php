@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Danh sách danh mục</h1>

    <a class="btn btn-primary mb-3" href="{{route('categories.create')}}">Tạo mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Số bài viết</th>
                <th>Số views</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $index=>$category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}">{{ $category->title }}</a>
                    </td>
                    <td>{{ $category->posts_count }}</td>
                    <td>{{ $category->posts->sum('views') }}</td>
                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $categories->links() !!}
    </div>
</div>
@endsection
