@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">إضافة سؤال جديد</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    @include('dashboard.inc.alerts')

                    <form action="{{ route('faqs.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="question">السؤال</label>
                            <input type="text" name="question" id="question" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="answer">الإجابة</label>
                            <textarea name="answer" id="answer" class="ckeditor form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
