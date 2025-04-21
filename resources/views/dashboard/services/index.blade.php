@extends('layouts.master')
@section('title', 'الخدمات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الخدمات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة الخدمات') }}</h4>
                            <a href="{{ route('services.create') }}" class="btn btn-primary">{{ __('إضافة خدمة جديدة') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="storestable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('عنوان الخدمة') }}</th>
                                        <th>{{ __('السعر') }}</th>
                                        <th>{{ __('الفئة') }}</th>
                                        <th>{{ __('الحالة') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $key => $service)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset('uploads/' . $service->image) }}" width="80"
                                                    height="80" alt=""></td>
                                            <td>{{ $service->title }}</td>
                                            <td>{{ $service->price }}</td>
                                            <td>{{ $service->category->name }}</td>
                                            <td>

                                                <input type="checkbox" data-id="{{ $service->id }}" name="status"
                                                    class="js-switch allssee" {{ $service->status == 1 ? 'checked' : '' }}>

                                            </td>
                                            <td>
                                                <a href="{{ route('services.edit', $service->id) }}"
                                                    class="btn btn-warning">{{ __('تعديل') }}</a>
                                                @if (isAdmin())
                                                    <form action="{{ route('services.destroy', $service->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
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
        $("#storestable").on("change", ".js-switch", function() {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let service_id = $(this).data('id');
            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_status_service') }}',
                data: {
                    'status': status,
                    'service_id': service_id
                },
                success: function(data) {
                    toastr.success("تم تعديل الحالة بنجاح");
                }
            });
        });
    </script>
@endsection
