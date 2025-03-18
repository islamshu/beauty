<section class="clearfix contactSection ">
    <div class="secotionTitle">
        <h2><span>خليك </span>على تواصل</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 col-xl-8">

                <form id="angelContactForm">
                    @csrf <!-- Add CSRF token for security -->
                    <div class="form-group">
                        <input type="text" id="name" name="contact-form-name" class="form-control" placeholder="اسمك" required>
                    </div>
                    <div class="form-group">
                        <input type="email" style="text-align: right" id="email" name="contact-form-email" class="form-control" placeholder="البريد الاكتروني" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="mobile" name="contact-form-mobile" class="form-control" placeholder="رقم الهاتف" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="message" name="contact-form-message" placeholder="رسالتك" required></textarea>
                    </div>
                    <div class="form-group">
                        <div style="text-align: center">
                            <button id="submitBtn" style="background: #c21ea7; text-align: center; padding: 20px;" type="button" class="btn custom-btn">
                                <i class="fa fa-paper-plane"></i> إرسال الطلب
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Success/Error Message -->
                
            </div>

            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="holdingInfo patternbg">
                    <ul>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> {{ get_general_value('address') }} </li>
                        <li><i class="fa fa-phone" aria-hidden="true"></i> {{ get_general_value('whatsapp_number') }}
                            <br>
                        </li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i> <a
                                href="mailto:{{ get_general_value('website_email') }} ">{{ get_general_value('website_email') }}
                            </a> <br>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
