@extends('layouts.master')
@section('title','الموظفين')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('الموظفين') }}</h3>
            </div>
        </div>
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('قائمة الموظفين') }}</h4>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">{{ __('إضافة موظف جديد') }}</a>
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <table class="table">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <th>{{ __('الصورة') }}</th>
                                    <th>{{ __('الاسم') }}</th>
                                    <th>{{ __('البريد الاكتروني') }}</th>
                                    <th>{{ __('الصلاحية') }}</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key=> $user)
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td><img src="{{asset('uploads/'.$user->image)}}" width="80" height="80" alt=""></td>

                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>@foreach ($user->roles as $item)
                                            <span class="fw-bold  @if( $item->name == 'admin')  text-info @else text-danger @endif">{{ $item->name }}</span>
                                        @endforeach</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
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
