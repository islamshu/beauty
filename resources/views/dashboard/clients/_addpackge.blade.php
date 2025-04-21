<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">إضافة باقة للعميل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSubscriptionForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="client_id" id="modalClientId">
                    
                    <div class="form-group">
                        <label for="modal_package_id">الباقة</label>
                        <select name="package_id" id="modal_package_id" class="form-control" required>
                            <option value="">اختر الباقة</option>
                            @foreach(App\Models\Package::where('status', 1)->get() as $package)
                            <option value="{{ $package->id }}" 
                                data-duration="{{ $package->number_date }}" 
                                data-duration-type="{{ $package->type_date }}"
                                data-price="{{ $package->price }}"
                                data-visits="{{ $package->number_of_visits }}">
                                {{ $package->name }} ({{ $package->price }} شيكل)
                            </option>
                        @endforeach
                        </select>
                    </div>

                    <div id="subscriptionFields">
                        <div class="form-group">
                            <label for="modal_start_date">{{ __('تاريخ البدء') }}</label>
                            <input type="date" class="form-control" name="start_date" id="modal_start_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label>{{ __('تاريخ الانتهاء') }}</label>
                            <input type="text" class="form-control" id="modal_end_date" readonly>
                            <small id="durationInfo" class="form-text text-muted"></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_payment_method">{{ __('طريقة الدفع') }}</label>
                            <select class="form-control" name="payment_method" id="modal_payment_method" required>
                                <option value="full">نقدي</option>
                                <option value="installments">تقسيط</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_total_amount">{{ __('المبلغ الإجمالي') }}</label>
                            
                            <input type="number" id="modal_total_amount" step="0.01" class="form-control" name="total_amount" required @if(!isAdmin()) readonly @endif >
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_package_visit">{{ __('عدد الزيارات للباقة') }}</label>
                            <input type="number" id="modal_package_visit_client" step="1" class="form-control" name="package_visit" required @if(!isAdmin()) readonly @endif>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_paid_amount">{{ __('المبلغ المدفوع') }}</label>
                            <input type="number" step="0.01" class="form-control" name="paid_amount" id="modal_paid_amount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-sm btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
