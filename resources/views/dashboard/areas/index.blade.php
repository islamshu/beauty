@extends('layouts.master')
@section('title','المناطق')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المناطق') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('المناطق') }}</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addAreaModal">{{ __('إضافة منطقة جديدة') }}</button>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="areastable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('المنطقة') }}</th>
                                        <th>{{ __('السعر') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($areas as $key => $area)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{$area->name}}</td>
                                            <td>{{ $area->price }} شيكل</td>
                                            <td>
                                                <button class="btn btn-warning" data-toggle="modal" data-target="#editAreaModal{{ $area->id }}">{{ __('تعديل') }}</button>

                                                <!-- Modal for editing area -->
                                                <div class="modal fade" id="editAreaModal{{ $area->id }}" tabindex="-1" role="dialog" aria-labelledby="editAreaModalLabel{{ $area->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editAreaModalLabel{{ $area->id }}">{{ __('تعديل المنطقة') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('areas.update', $area->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('اسم المنطقة') }}</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $area->name }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="price">{{ __('سعر التوصيل للمنطقة') }}</label>
                                                                        <input type="number" class="form-control" name="price" value="{{ $area->price }}" step="0.01" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">{{ __('حفظ التعديلات') }}</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="{{ route('areas.destroy', $area->id) }}" method="POST" style="display: inline-block;">
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

    <!-- Modal for adding new image -->
    <div class="modal fade" id="addAreaModal" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAreaModalLabel">{{ __('إضافة منقطة جديدة') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('areas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="text">{{ __('اسم المنقطة') }}</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="text">{{ __('سعر التوصيل للمنطقة') }}</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('إضافة') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
