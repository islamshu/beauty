@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إضافة صورة جديدة') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('galleries.index') }}">{{ __('معرض الصور') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('إضافة صورة جديدة') }}</li>
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
                                <h4 class="card-title">{{ __('إضافة صورة جديدة') }}</h4>
                            </div>
                            <div class="card-content">
                                @include('dashboard.inc.alerts')
                                <div class="card-body">
                                    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group col-8">
                                            <label for="title">{{ __('العنوان') }}</label>
                                            <textarea name="title" id="title" class=" ckeditor form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="description">{{ __('الوصف') }}</label>
                                            <textarea name="description" id="description" class="ckeditor form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="image">{{ __('الصورة') }}</label>
                                            <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                                            <div style="margin-top: 10px;">
                                                <img id="preview" src="" alt="{{ __('معاينة الصورة') }}" style="max-width: 300px; display: none; border: 1px solid #ccc; padding: 5px;">
                                            </div>
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

@section('script')
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
@endsection
