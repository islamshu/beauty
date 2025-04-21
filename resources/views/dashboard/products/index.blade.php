@extends('layouts.master')
@section('title','المنتجات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المنتجات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة المنتجات') }}</h4>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">{{ __('إضافة منتج جديد') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="productstable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('عنوان المنتج') }}</th>
                                        <th>{{ __('السعر قبل الخصم') }}</th>
                                        <th>{{ __('السعر بعد الخصم') }}</th>
                                        <th>{{ __('الفئة') }}</th>
                                        <th>{{__('الحالة')}}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset('uploads/' . $product->image) }}" width="80" height="80" alt=""></td>
                                            <td>{{ $product->title }}</td>
                                            <td>{{ $product->price_before_discount }}</td>
                                            <td>{{ $product->price_after_discount }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>
                                                <input type="checkbox" data-id="{{ $product->id }}" name="status" class="js-switch allssee"
                                                {{ $product->status == 1 ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>
                                                @if (isAdmin())
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                                </form>
                                                @endif
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
@endsection

@section('script')
<script>
    $("#productstable").on("change", ".js-switch", function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let product_id = $(this).data('id');
        $.ajax({
            type: "get",
            dataType: "json",
            url: '{{ route('update_status_product') }}',
            data: {
                'status': status,
                'product_id': product_id
            },
            success: function(data) {
                toastr.success("تم تعديل الحالة بنجاح");
            }
        });
    });
</script>
@endsection