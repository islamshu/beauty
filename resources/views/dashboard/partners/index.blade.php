@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('شركائنا') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('شركائنا') }}</li>
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
                                <h4 class="card-title">{{ __('قائمة الشركاء') }}</h4>
                                <a href="{{ route('partners.create') }}" class="btn btn-primary">{{ __('إضافة شريك جديد') }}</a>
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
                                                <th>{{ __('الصورة') }}</th>
                                                <th>{{ __('الإجراءات') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($partners as $gallery)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{!! $gallery->title !!}</td>
                                                    <td>{!! $gallery->description !!}</td> --}}
                                                    <td>
                                                        <img src="{{ asset('uploads/' . $gallery->image) }}" width="100">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('partners.edit', $gallery->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>
                                                        <form action="{{ route('partners.destroy', $gallery->id) }}" method="POST" style="display: inline-block;">
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
