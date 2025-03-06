@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل الفيديو') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('videos.index') }}">{{ __('الفيديوهات') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل الفيديو') }}</li>
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
                                <h4 class="card-title">{{ __('تعديل الفيديو') }}</h4>
                            </div>
                            <div class="card-content">
                                @include('dashboard.inc.alerts')

                                <div class="card-body">
                                    <form id="uploadForm" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group col-8">
                                            <label for="title">{{ __('عنوان الفيديو') }}</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ $video->title }}" required>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="video">{{ __('تحميل فيديو جديد') }}</label>
                                            <input type="file" name="video" id="video" class="form-control" accept="video/*">
                                            <p>{{ __('الفيديو الحالي:') }}</p>
                                            <video width="300" controls>
                                                <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                                {{ __('متصفحك لا يدعم تشغيل الفيديو.') }}
                                            </video>
                                        </div>
                                        <div class="form-group col-8">
                                            <label>{{ __('التقدم') }}</label>
                                            <div class="progress" style="height: 20px;">
                                                <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;">0%</div>
                                            </div>
                                        </div>
                                        <button type="button" id="uploadButton" class="btn btn-success">{{ __('تحديث') }}</button>
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
    document.getElementById('uploadButton').addEventListener('click', function () {
        const form = document.getElementById('uploadForm');
        const formData = new FormData(form);
        const progressBar = document.getElementById('progress-bar');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('videos.update', $video->id) }}', true);

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                const percentComplete = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percentComplete + '%';
                progressBar.textContent = percentComplete + '%';
            }
        });

        xhr.onload = function () {
            if (xhr.status === 200) {
                alert('تم تحديث الفيديو بنجاح');
                window.location.href = '{{ route('videos.index') }}';
            } else {
                alert('حدث خطأ أثناء تحديث الفيديو');
            }
        };

        xhr.send(formData);
    });
</script>
@endsection
@endsection
