@extends('layout')
@section('content')
    <div class="container mt-4">
        <h1>Thêm danh mục mới</h1>
        <form method="POST" action="{{route('categories.store')}}">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                @error('title')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        </form>
    </div>
@endsection