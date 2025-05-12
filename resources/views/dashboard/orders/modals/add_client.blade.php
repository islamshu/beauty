<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addClientModalLabel">{{ __('إضافة عميل جديد من الطلب') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="addClientForm" action="{{ route('clients.storeFromOrder') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" id="orderIdInput">
            <input type="hidden" name="package_id" id="packageIdInput" value="{{ @$order->package->id }}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('بيانات الطلب') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('اسم العميل') }}</label>
                                    <input type="text" class="form-control" id="displayOrderName" readonly>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('رقم الهاتف') }}</label>
                                    <input type="text" class="form-control" id="displayOrderPhone" readonly>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('الباقة المطلوبة') }}</label>
                                    <input type="text" class="form-control" id="displayOrderPackage" readonly>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('سعر الباقة') }}</label>
                                    <input type="text" class="form-control" id="displayOrderPrice" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('بيانات العميل الجديد') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="clientName">{{ __('اسم العميل') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="clientName" name="name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="phoneNumber">رقم الهاتف</label>
                                    <div class="input-group input-group-sm">
                                        <input type="tel" class="form-control" id="phoneNumber"
                                            placeholder="0592412365" readonly name="phone" pattern="^0[0-9]{9}$"
                                            title="يجب إدخال 10 أرقام بالضبط" maxlength="10" required>
                                        <select readonly class="form-control country-code-select" name="country_code"
                                            id="countryCode" style="max-width: 80px;">
                                            <option value="+970">970</option>
                                            <option value="+972">972</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="clientAddress">{{ __('العنوان') }}</label>
                                    <input type="text" class="form-control" id="clientAddress"
                                        name="address">
                                </div>

                                <!-- إضافة خيارات الاشتراك -->
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="addSubscription"
                                            name="add_subscription" value="1" checked>
                                        <label class="custom-control-label"
                                            for="addSubscription">{{ __('إضافة اشتراك بالباقة المطلوبة') }}</label>
                                    </div>
                                </div>

                                <div id="subscriptionFields">
                                    <div class="form-group">
                                        <label for="start_date">{{ __('تاريخ البدء') }}</label>
                                        <input type="date" class="form-control" name="start_date"
                                            id="startDate">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('تاريخ الانتهاء') }}</label>
                                        <input type="text" class="form-control" id="endDate" readonly>
                                        <small id="durationInfo" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_method">{{ __('طريقة الدفع') }}</label>
                                        <select class="form-control" name="payment_method" required>
                                            <option value="full">نقدي</option>
                                            <option value="installments">تقسيط</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="total_amount">{{ __('المبلغ الإجمالي') }}</label>
                                        <input type="number" id="total_amount" step="0.01"
                                            class="form-control" name="total_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="packgevisit">{{ __('عدد الزيارات للباقة') }}</label>
                                        <input type="number" id="packgevisit" step="1"
                                            class="form-control" name="package_visit" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="paid_amount">{{ __('المبلغ المدفوع') }}</label>
                                        <input type="number" step="0.01" class="form-control"
                                            name="paid_amount" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">{{ __('إلغاء') }}</button>
                <button type="submit" class="btn btn-primary" id="saveClientBtn">
                    <i class="ft-save"></i> {{ __('حفظ العميل والاشتراك') }}
                </button>
            </div>
        </form>
    </div>
</div>
</div>