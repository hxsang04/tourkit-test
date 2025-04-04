@extends('layout')
@section('content')
    <div class="container">
        <h1>Thêm danh mục mới</h1>
        <form id="create-category">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#create-category').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            console.log(formData);
            // $.ajax({
            //     url: '{{ route("categories.ajax-store") }}',
            //     method: 'POST',
            //     data: formData,
            //     dataType: 'JSON',
            //     success: function (response) {
            //         if (response.status === 'success') {
            //             $('#successMessage').removeClass('d-none').text(response.message);

            //             $('#createPostForm')[0].reset();
            //         }
            //     },
            //     error: function (xhr) {
            //         var errors = xhr.responseJSON.errors;
            //         var errorMessage = 'Đã xảy ra lỗi. Vui lòng thử lại.';
            //         if (errors) {
            //             errorMessage = Object.values(errors).join('<br>');
            //         }
            //         $('#errorMessage').removeClass('d-none').html(errorMessage);
            //     }
            // });
        });
    });
</script>
@endsection
