@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إضافة فيديو جديد') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('videos.index') }}">{{ __('الفيديوهات') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('إضافة فيديو جديد') }}</li>
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
                                <h4 class="card-title">{{ __('إضافة فيديو جديد') }}</h4>
                            </div>
                            <div class="card-content">
                                @include('dashboard.inc.alerts')

                                <div class="card-body">
                                    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group col-8">
                                            <label for="title">{{ __('عنوان الفيديو') }}</label>
                                            <input type="text" name="title" id="title" class="form-control" required>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="video">{{ __('تحميل الفيديو') }}</label>
                                            <input type="file" name="video" id="video" class="form-control" accept="video/*" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">{{ __('حفظ') }}</button>
                                    </form>
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
