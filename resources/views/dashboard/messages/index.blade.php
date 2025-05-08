@extends('layouts.master')
@section('title','قائمة الصور')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الرسائل') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                      
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table table-bordered table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>المفتاح</th>
                                        <th>المحتوى</th>
                                        <th>التحكم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr>
                                            <td>{{ $message->key }}</td>
                                            <td>{{ Str::limit($message->content, 100) }}</td>
                                            <td>
                                                <a href="{{ route('messages.edit', $message->key) }}" class="btn btn-sm btn-primary">تعديل</a>
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

    <!-- Modal for adding new image -->

@endsection

@section('script')

@endsection
