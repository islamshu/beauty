@extends('layouts.master')
@section('title','الفئات')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('الفئات') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('الفئات') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-body">
                        @include('dashboard.inc.alerts')
                        
                        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#categoryModal">إضافة فئة</button>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="category-list">
                                @foreach($categories as $category)
                                <tr id="category-{{ $category->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}">تعديل</button>
                                        <button class="btn btn-sm btn-danger delete-category" data-id="{{ $category->id }}">حذف</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة / تعديل فئة</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="category-form">
                    @csrf
                    <input type="hidden" id="category-id">
                    <div class="form-group">
                        <label for="category-name">اسم الفئة</label>
                        <input type="text" id="category-name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var routes = {
        store: "{{ route('categories.store') }}",
        update: "{{ route('categories.update', ':id') }}",
        destroy: "{{ route('categories.destroy', ':id') }}"
    };
</script>
<script>
  $(document).ready(function() {
    // إضافة أو تعديل فئة
    $('#category-form').submit(function(e) {
        e.preventDefault();
        let id = $('#category-id').val();
        let name = $('#category-name').val();
        let url = id ? routes.update.replace(':id', id) : routes.store;
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: { name: name, _token: '{{ csrf_token() }}' },
            success: function(response) {
    console.log(response); // تحقق مما يعيده الخادم
    $('#categoryModal').modal('hide');

    if (id) {
        $('#category-' + id).find('td:nth-child(2)').text(response.category.name);
        toastr.success("تم تعديل الفئة بنجاح ! ");

    } else {
        let newRow = `
    <tr id="category-${response.category.id}">
        <td>${$('#category-list tr').length + 1}</td>
        <td>${response.category.name}</td>
        <td>
            <button class="btn btn-sm btn-warning edit-category" data-id="${response.category.id}" data-name="${response.category.name}">تعديل</button>
            <button class="btn btn-sm btn-danger delete-category" data-id="${response.category.id}">حذف</button>
        </td>
    </tr>
`;

        $('#category-list').append(newRow);
        toastr.success("تم انشاء الفئة بنجاح ! ");

    }

    $('#category-id').val('');
    $('#category-name').val('');
}

        });
    });

    // فتح نموذج التعديل
    $(document).on('click', '.edit-category', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        $('#category-id').val(id);
        $('#category-name').val(name);
        $('#categoryModal').modal('show');
    });

    // حذف فئة
    $(document).on('click', '.delete-category', function() {
        let id = $(this).data('id');
        let deleteUrl = routes.destroy.replace(':id', id);

        if (confirm('هل أنت متأكد من حذف هذه الفئة؟')) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    $('#category-' + id).fadeOut(500, function() { $(this).remove(); });
                    toastr.success("تم حذف الفئة بنجاح ! ");

                }
            });
        }
    });
});

</script>
@endsection