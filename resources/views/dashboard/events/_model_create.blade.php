<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg model_add">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">إضافة حجز</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- اسم الزبون -->
                        <div class="col-md-6 mb-3">
                            <label for="client_id" class="form-label">اسم الزبون <span
                                    class="text-danger">*</span></label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="" disabled selected>اختر العميل</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- عنوان الحجز -->
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">اسم الموظف <span
                                    class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="" disabled selected>اختر المستخدم</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- التاريخ -->
                        <div class="col-md-12">
                            <div class="form-group border rounded p-3 bg-white shadow-sm">
                                <label class="font-weight-bold mb-2">🗓️ تاريخ الحجز</label>
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="d-flex align-items-center mr-3 mb-2">
                                        <i class="far fa-clock mr-2 text-muted"></i>
                                        <input type="date"
                                            class="form-control rounded-pill bg-light border-0 px-3 py-2" name="date"
                                            id="reservationDate" required>
                                    </div>

                                    <div class="d-flex align-items-center mb-2">
                                        <input type="time"
                                            class="form-control rounded-pill bg-light border-0 px-3 py-2 mr-2"
                                            name="start_time" id="startTimeInput" required>
                                        <span class="mx-1">–</span>
                                        <input type="time"
                                            class="form-control rounded-pill bg-light border-0 px-3 py-2"
                                            name="end_time" id="endTimeInput" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- اسم الموظف -->
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">عنوان الحجز <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title') }}" required>
                        </div>

                        <!-- الخدمات -->
                        <div class="col-md-6 mb-3">
                            <label for="services" class="form-label">الخدمات <span class="text-danger">*</span></label>
                            <select name="services[]" id="services" class="form-control select2" multiple>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->title }} -
                                        {{ $service->price }} شيكل</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الملاحظات -->
                        <div class="col-md-6 mb-3">
                            <label for="nots" class="form-label">الملاحظات</label>
                            <textarea name="nots" id="nots" class="form-control">{{ old('nots') }}</textarea>
                        </div>

                        <!-- السبب -->
                        <div class="col-md-6 mb-3">
                            <label for="reason" class="form-label">السبب</label>
                            <textarea name="reason" id="reason" class="form-control">{{ old('reason') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">حفظ الحجز</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // عند تغيير الموظف أو التاريخ
        $('#user_id, #reservationDate').change(function() {
            const userId = $('#user_id').val();
            const date = $('#reservationDate').val();

            if (userId && date) {
                fetchLastReservation(userId, date);
            } else {
                // إعادة تعيين القيم إذا لم يتم اختيار الموظف أو التاريخ
                $('#startTimeInput').val('');
                $('#endTimeInput').val('');
            }
        });

        // دالة لجلب آخر حجز للموظف في التاريخ المحدد
        function fetchLastReservation(userId, date) {
            $.ajax({
                url: '{{ route('reservations.getLastByUser') }}',
                method: 'GET',
                data: {
                    user_id: userId,
                    date: date
                },
                success: function(response) {
                    if (response.lastReservation && response.lastReservation.end_time) {
                        // تحويل الوقت إلى تنسيق 24 ساعة
                        const lastEndTime = response.lastReservation.end_time;

                        // تعيين وقت البدء كآخر وقت نهاية
                        $('#startTimeInput').val(lastEndTime);

                        // حساب وقت النهاية (نصف ساعة بعد وقت البدء)
                        try {
                            const endTime = add30Minutes(lastEndTime);
                            $('#endTimeInput').val(endTime);
                        } catch (e) {
                            console.error('Error calculating end time:', e);
                            $('#endTimeInput').val('');
                        }
                    } else {
                        // إذا لم يكن هناك حجوزات سابقة، استخدم الوقت الافتراضي
                        $('#startTimeInput').val('09:00');
                        $('#endTimeInput').val('09:30');
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching last reservation:', xhr.responseText);
                }
            });
        }

        // دالة محسنة لإضافة 30 دقيقة إلى الوقت مع معالجة الأخطاء
        function add30Minutes(time) {
    // 1. التحقق من صحة المدخلات
    if (!time || typeof time !== 'string') {
        console.error('خطأ: قيمة الوقت غير صالحة');
        return '09:00'; // قيمة افتراضية
    }

    // 2. تنظيف المدخلات
    time = time.trim().replace(/\s/g, '');

    // 3. التحقق من التنسيق الصحيح (HH:MM)
    if (!/^(\d{1,2}):(\d{2})$/.test(time)) {
        console.error('خطأ: تنسيق الوقت يجب أن يكون HH:MM');
        return '09:00';
    }

    // 4. استخراج الساعات والدقائق
    const [h, m] = time.split(':').map(Number);

    // 5. معالجة القيم غير الرقمية
    let hours = isNaN(h) ? 0 : h;
    let minutes = isNaN(m) ? 0 : m;

    // 6. إضافة 90 دقيقة (التغيير الرئيسي هنا)
    minutes += 90;
    hours += Math.floor(minutes / 60);
    minutes %= 60;
    hours %= 24;

    // 7. إرجاع النتيجة بالتنسيق الصحيح
    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
}

        // باقي الكود الأصلي...
        $('form').on('submit', function(e) {
            e.preventDefault();

            let form = this;
            let data = {
                date: $('input[name="date"]').val(),
                start_time: $('input[name="start_time"]').val(),
                end_time: $('input[name="end_time"]').val(),
                user_id: $('#user_id').val(),
                _token: '{{ csrf_token() }}'
            };

            if (!data.start_time || !data.end_time) {
                alert('الرجاء تحديد وقت البدء ووقت النهاية');
                return;
            }

            $.post('{{ route('reservations.checkConflict') }}', data, function(response) {
                if (response.status === 'conflict') {
                    const formattedStart = formatDateTime(response.start);
                    const formattedEnd = formatDateTime(response.end);

                    alert(
                        `⚠️ يوجد تعارض مع الحجز: "${response.title}" من ${formattedStart} إلى ${formattedEnd}`
                    );
                } else {
                    form.submit(); // لا يوجد تعارض → أرسل النموذج
                }
            }).fail(function() {
                alert('حدث خطأ أثناء التحقق من التعارض');
            });
        });

        function formatDateTime(datetimeStr) {
            if (!datetimeStr) return '';
            const date = new Date(datetimeStr);
            if (isNaN(date.getTime())) return datetimeStr;

            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            };
            return date.toLocaleString('ar-EG', options).replace(',', '');
        }

        // التحقق من صحة وقت النهاية
        $('#endTimeInput').change(function() {
            const startDate = $('input[name="date"]').val();
            const startTime = $('input[name="start_time"]').val();
            const endTime = $(this).val();

            if (!startDate || !startTime || !endTime) return;

            const startDateTime = new Date(`${startDate}T${startTime}`);
            const endDateTime = new Date(`${startDate}T${endTime}`);

            if (endDateTime <= startDateTime) {
                alert('تاريخ ووقت النهاية يجب أن يكون بعد تاريخ ووقت البداية');
                $(this).val('');
            }
        });

        // تهيئة Select2
        $('#services').select2({
            dropdownParent: $('#reservationModal')
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // التحقق عند تغيير حقل وقت النهاية
        const endTimeInput = document.querySelector('[name="end_time"]');
        endTimeInput.addEventListener('change', function() {
            const startDate = document.querySelector('[name="date"]').value;
            const startTime = document.querySelector('[name="start_time"]').value;
            const endTime = endTimeInput.value;

            const startDateTime = new Date(startDate + 'T' + startTime);
            const endDateTime = new Date(startDate + 'T' + endTime);

            if (endDateTime <= startDateTime) {
                alert('تاريخ ووقت النهاية يجب أن يكون بعد تاريخ ووقت البداية');
                endTimeInput.value = '';
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#services').select2({
            dropdownParent: $('#reservationModal')
        });
    });
</script>
