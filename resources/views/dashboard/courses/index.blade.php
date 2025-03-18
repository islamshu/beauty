@extends('layouts.master')
@section('title','الدورات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الكورسات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة الكورسات') }}</h4>
                            <a href="{{ route('courses.create') }}" class="btn btn-primary">{{ __('إضافة كورس جديد') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="coursestable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('عنوان الكورس') }}</th>
                                        <th>{{ __('السعر') }}</th>
                                        <th>{{ __('الفئة') }}</th>
                                        <th>{{__('الحالة')}}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $key => $course)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset('uploads/' . $course->image) }}" width="80" height="80" alt=""></td>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->price }}</td>
                                            <td>{{ $course->category->name }}</td>
                                            <td>
                                                <input type="checkbox" data-id="{{ $course->id }}" name="status" class="js-switch allssee"
                                                {{ $course->status == 1 ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>
                                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
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
    $("#coursestable").on("change", ".js-switch", function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let course_id = $(this).data('id');
        $.ajax({
            type: "get",
            dataType: "json",
            url: '{{ route('update_status_course') }}',
            data: {
                'status': status,
                'course_id': course_id
            },
            success: function(data) {
                toastr.success("تم تعديل الحالة بنجاح");
            }
        });
    });
</script>
@endsection