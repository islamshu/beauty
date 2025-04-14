@extends('layouts.master')
@section('title', 'تفاصيل الصلاحية')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">تفاصيل الصلاحية: {{ $role->name }}</h4>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">رجوع</a>
                </div>

                <div class="card-body">
                    <h5>اسم الصلاحية: <strong>{{ $role->name }}</strong></h5>
                    <h5>الأذونات:</h5>
                    <ul>
                        @foreach($role->permissions as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
