@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Danh sách bài viết</h1>
        <a class="btn btn-primary" href="{{ route('posts.create') }}">Tạo mới</a>
    </div>

    <div class="mb-3 d-flex align-items-center">
        <input type="text" id="keyword" class="form-control me-2" placeholder="Từ khóa" style="width: 300px;">
        <select id="category_filter" class="form-control me-2" style="width: 200px;">
            <option value="">Chọn danh mục</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
        <button id="apply-filters" class="btn btn-primary">Lọc</button>
    </div>

    <table id="posts-table" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Số view</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
    </table>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#posts-table').DataTable({
            processing: true,
            searching: false,
            serverSide: true,
            ajax: {
                url: '{{ route('posts.get-data') }}',
                data: function(d) {
                    d.keyword = $('#keyword').val();
                    d.category_id = $('#category_filter').val();
                    if (d.order.length > 0){
                        d.order_column = d.columns[d.order[0].column].data;
                        d.order_dir = d.order[0].dir;
                    }
                }
            },
            columns: [
                { data: 'id', orderable: true },
                { 
                    data: 'title', 
                    orderable: true ,
                    render: function(data, type, row) {
                        return `<a href="/posts/${row.id}/edit">${data}</a>`;
                    }
                },
                { 
                    data: 'categories' ,
                    orderable: false,
                    render: function(data, type, row) {
                        return data.map(category => `<div>- ${category.title}</div>`).join('');
                    }
                },
                { data: 'views', className: 'text-center', orderable: true },
                { data: 'created_at' },
                {
                    render: function(data, type, row) {
                        var deleteUrl = `/posts/${row.id}/destroy`;

                        return `
                                <form action="${deleteUrl}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')" class="btn btn-danger">Xóa</button>
                                </form>
                            `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#apply-filters').click(function() {
            table.draw();
        });

    });
</script>
@endpush
