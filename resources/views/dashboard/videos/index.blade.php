@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('معرض الفيديوهات') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('معرض الفيديوهات') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('قائمة الفيديوهات') }}</h4>
                                <a href="{{ route('videos.create') }}" class="btn btn-primary">{{ __('إضافة فيديو جديد') }}</a>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @include('dashboard.inc.alerts')

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                {{-- <th>{{ __('العنوان') }}</th>
                                                <th>{{ __('الوصف') }}</th> --}}
                                                <th>{{ __('الفيديوهاتة') }}</th>
                                                <th>{{ __('الإجراءات') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($videos as $video)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{!! $video->title !!}</td>
                                                    <td>{!! $video->description !!}</td> --}}
                                                    <td>
                                                        <video width="320" height="240" controls>
                                                            <source src="{{ asset('uploads/' . $video->video) }}" type="video/mp4">
                                                            <source src="{{ asset('uploads/' . $video->video) }}" type="video/webm">
                                                            {{ __('متصفحك لا يدعم تشغيل الفيديو.') }}
                                                        </video>                                                    </td>
                                                    <td>
                                                        <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>
                                                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST" style="display: inline-block;">
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
