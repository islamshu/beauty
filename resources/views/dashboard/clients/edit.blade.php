@extends('layouts.master')
@section('title','تعديل العميل')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل بيانات العميل') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('العملاء') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل بيانات العميل') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <form action="{{ route('clients.update', $client->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- اسم العميل -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('اسم العميل') }} <span class="required">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- رقم الهاتف -->
                                <div class="col-md-6">
                                      <div class="form-group">
                                                        <label for="phoneNumber">رقم الهاتف *</label>
                                                        <div class="input-group input-group-sm">
                                                         <input type="tel" class="form-control" id="phoneNumber"
                                                            name="phone"
                                                            value="{{ old('phone', $phone) }}"
                                                            placeholder="0592412365"
                                                            pattern="^0[0-9]{9}$"
                                                            title="يجب إدخال 10 أرقام بالضبط" maxlength="10" required>

                                                        <select class="form-control country-code-select" name="country_code" id="countryCode" required style="max-width: 80px;">
                                                            <option value="+970" {{ old('country_code', $country_code) == '+970' ? 'selected' : '' }}>970</option>
                                                            <option value="+972" {{ old('country_code', $country_code) == '+972' ? 'selected' : '' }}>972</option>
                                                        </select>
                                                        </div>
                                                         <span class="text-danger d-block mt-1" id="phone_error"></span>
                                                        <span class="text-danger d-block mt-1"
                                                            id="country_code_error"></span>
                                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- العنوان -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">{{ __('العنوان') }}</label>
                                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $client->address) }}">
                                        @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                
                            </div>


                            <!-- زر الحفظ -->
                            <button type="submit" class="btn btn-success">{{ __('حفظ التعديلات') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
