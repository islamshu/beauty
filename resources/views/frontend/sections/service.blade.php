<!-- قسم الخدمات -->
<section class="clearfix varietySection">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>الخدمات </span>المميزة</h2>
        </div>
    
    
    <div class="container mt-5">
        <div class="row">
            @foreach ($services as $item)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card-container" onclick="openWhatsApp('{{ $item->title }}')">
                    <div class="card">
                        <!-- Front Face -->
                        <div class="card-face front">
                            <img class="lazyestload" src="{{ asset('uploads/' . $item->image) }}" data-src="{{asset('uploads/' . $item->image) }}" alt="Service Image">
                            <div class="overlay">{{ $item->title }}</div>
                        </div>
                        <!-- Back Face -->
                        <div class="card-face back">
                            <p>{!! $item->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="more-services">
            <a href="{{route('services')}}" class="more-services-btn">المزيد من الخدمات</a>
        </div>
    </div>
</section>

<script>
    function openWhatsApp(serviceName) {
        const phoneNumber =`{{ get_general_value('whatsapp_number')}}`;
        const message = `مرحباً، أنا مهتم بخدمة ${serviceName}، هل يمكنكم تقديم المزيد من المعلومات؟`;
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        window.open(whatsappUrl, '_blank');
    }
    
    // Optional: Separate click handler for the "View More" button
    document.querySelectorAll('.view-more-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent triggering the card click
            const card = this.closest('.card-container');
            const serviceTitle = card.querySelector('.overlay').textContent;
            openWhatsApp(serviceTitle);
        });
    });
    

</script>


<!-- نافذة الحجز -->
<div id="appoinmentModal" class="modal fade modalCommon" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title appointment-modal-title">حجز موعد لـ <span id="service-title"></span></h4>
            </div>
            <div class="modal-body">
                <form id="appoinmentModalForm">
                    @csrf
                    <div class="form-group categoryTitle">
                        <h5>تاريخ ووقت الخدمة</h5>
                    </div>
                    <div class="form-group">
                        <input type="datetime-local" name="appointment_date" class="form-control" placeholder="التاريخ" required>
                        <span class="text-danger error-appointment_date"></span> <!-- مكان الخطأ -->
                    </div>
                
                    <div class="form-group categoryTitle">
                        <h5>المعلومات الشخصية</h5>
                    </div>
                    <input type="hidden" name="service_id" id="service-id">
                    <span class="text-danger error-service_id"></span> <!-- مكان الخطأ -->
                
                    <div class="form-group">
                        <input type="text" name="full_name" class="form-control" placeholder="الاسم الكامل" required>
                        <span class="text-danger error-full_name"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <input type="text" name="id_number" class="form-control" placeholder="رقم الهوية " required>
                        <span class="text-danger error-id_number"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="رقم الهاتف" required>
                        <span class="text-danger error-phone"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="address" placeholder="عنوانك" required></textarea>
                        <span class="text-danger error-address"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <button type="button" id="send_button" class="btn btn-primary">إرسال الآن</button>
                    </div>
                </form>
                
                
                
                
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.open-appointment-modal').on('click', function() {
            var serviceTitle = $(this).data('service-title');
            var servicePrice = $(this).data('service-price');
            
            $('#service-title').text(serviceTitle);
            $('.appointment-modal-title').text('حجز موعد لـ ' + serviceTitle);
        });
    });
</script>