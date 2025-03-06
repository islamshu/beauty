@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">الأسئلة الشائعة</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <a href="{{ route('faqs.create') }}" class="btn btn-primary mb-3">إضافة سؤال جديد</a>
                    <div class="card">
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>السؤال</th>
                                        <th>الإجابة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $faq)
                                        <tr>
                                            <td>{{ $faq->question }}</td>
                                            <td>{!! $faq->answer !!}</td>
                                            <td>
                                                <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-warning">تعديل</a>
                                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">حذف</button>
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
