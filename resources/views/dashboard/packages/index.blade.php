@extends('layouts.master')
@section('title','الباقات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الباقات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة الباقات') }}</h4>
                            <a href="{{ route('packages.create') }}" class="btn btn-primary">{{ __('إضافة باقة جديد') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="storestable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('اسم الباقة') }}</th>
                                        <th>{{ __('سعر الباقة') }}</th>
                                        <th>{{ __('الحالة') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $key => $package)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset('uploads/' . $package->image) }}" width="80"
                                                    height="80" alt=""></td>

                                            <td>{{ $package->name }}</td>
                                            <td>{{ $package->price }}</td>
                                            <td>

                                                <input type="checkbox" data-id="{{ $package->id }}" name="status" class="js-switch allssee"
                                                {{ $package->status == 1 ? 'checked' : '' }}>

                                            </td>
                                            <td>
                                                <a href="{{ route('packages.edit', $package->id) }}"
                                                    class="btn btn-warning">{{ __('تعديل') }}</a>
                                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                                </form>
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
    $("#storestable").on("change", ".js-switch", function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let package_id = $(this).data('id');
                $.ajax({
                    type: "get",
                    dataType: "json",
                    url: '{{ route('update_status_package') }}',
                    data: {
                        'status': status,
                        'package_id': package_id
                    },
                    success: function(data) {
                        toastr.success("تم تعديل الحالة بنجاح");
                    }
                });
            });
</script>
@endsection
