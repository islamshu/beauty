<script>
    $(document).ready(function() {
        // عند فتح المودال
        $('#addClientModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var clientId = button.data('client-id');
            $(this).find('#modalClientId').val(clientId);

            // تعيين تاريخ اليوم كتاريخ بدء افتراضي
            var today = new Date().toISOString().split('T')[0];
            $('#modal_start_date').val(today);
        });

        // عند تغيير الباقة
        $('#modal_package_id').change(function() {
            var selectedOption = $(this).find('option:selected');

            // إذا تم اختيار باقة (وليست الخيار الافتراضي)
            if ($(this).val()) {
                // جلب بيانات الباقة من خصائص data
                var packagePrice = selectedOption.data('price');
                var packageVisits = selectedOption.data('visits');
                // تعبئة الحقول تلقائياً
                $('#modal_total_amount').val(packagePrice);
                $('#modal_package_visit_client').val(packageVisits);

                // حساب تاريخ الانتهاء إذا كان تاريخ البدء محدد
                if ($('#modal_start_date').val()) {
                    calculateEndDate();
                }

                // عرض معلومات المدة
                var duration = selectedOption.data('duration');
                var durationType = selectedOption.data('duration-type');
                $('#durationInfo').text(`مدة الباقة: ${duration} ${getDurationText(durationType)}`);
            } else {
                // إذا لم يتم اختيار باقة، مسح الحقول
                $('#modal_total_amount').val('');
                $('#modal_package_visit_client').val('');
                $('#modal_end_date').val('');
                $('#durationInfo').text('');
            }
        });


        // عند تغيير تاريخ البدء
        $('#modal_start_date').change(function() {
            if ($('#modal_package_id').val()) {
                calculateEndDate();
            }
        });

        // دالة لحساب تاريخ الانتهاء
        function calculateEndDate() {
            var packageId = $('#modal_package_id').val();
            var startDate = $('#modal_start_date').val();

            if (!packageId || !startDate) return;
            let url = "{{ route('packages.calculate-end-date', ['package' => ':packageId']) }}".replace(
                ':packageId',
                packageId);
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    package: packageId,
                    start_date: startDate
                },
                success: function(response) {
                    $('#modal_end_date').val(response.end_date);
                },
                error: function(xhr) {
                    console.error('Error calculating end date:', xhr.responseText);
                }
            });
        }

        // دالة مساعدة للحصول على نص المدة
        function getDurationText(type) {
            switch (type) {
                case 'day':
                    return 'يوم';
                case 'week':
                    return 'أسبوع';
                case 'month':
                    return 'شهر';
                case 'year':
                    return 'سنة';
                default:
                    return '';
            }
        }

        // إرسال النموذج
        $('#addSubscriptionForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('subscriptions.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#addClientModal').modal('hide');
                    toastr.success(response.message ||
                        '{{ __('تمت إضافة الباقة بنجاح') }}');

                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },

                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = '';

                    $.each(errors, function(key, value) {
                        errorMessages += value + '<br>';
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        html: errorMessages,
                    });
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const packageSelect = document.getElementById('modal_package_id');
        const totalAmountInput = document.getElementById('modal_total_amount');
        const totalVist = document.getElementById('modal_package_visit_client');

        // عند تغيير الباقة
        packageSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const packagePrice = selectedOption.getAttribute('data-price');
            const packageVist = selectedOption.getAttribute('data-visit');

            // تعيين سعر الباقة في حقل المبلغ الإجمالي
            totalAmountInput.value = packagePrice;
            totalVist.value = packageVist;

        });

        // تهيئة القيمة عند فتح المودال (إذا لزم الأمر)
        if (packageSelect.value) {
            packageSelect.dispatchEvent(new Event('change'));
        }
    });
</script>