@include('dashboard.inc.head')
<body class="horizontal-layout horizontal-menu 1-column   menu-expanded blank-page blank-page"
data-open="hover" data-menu="horizontal-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img src="{{ asset('uploads/'.get_general_value('website_logo')) }}" width="200" height="200
                      " alt="branding logo">
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>{{ __('Login to')  }} {{ get_general_value('website_name') }} </span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('dashboard.inc.alerts')

                    <form class="form-horizontal form-simple" method="post" action="{{ route('post_login') }}" novalidate>
                        @csrf
                      <fieldset class="form-group position-relative has-icon-left mb-0">
                        <input type="email" class="form-control form-control-lg input-lg" name="email" id="user-name" placeholder="{{ __('Email') }}"
                        required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <br>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" name="password" class="form-control form-control-lg input-lg" id="user-password"
                        placeholder="{{ __('Password') }}" required>
                        <div class="form-control-position">
                          <i class="ft-lock"></i>
                        </div>
                      </fieldset>
                      
                      <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> {{ __('Login') }}</button>
                    </form>
                  </div>
                </div>
 
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="../../../app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="../../../app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="../../../app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <script src="../../../app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="../../../app-assets/js/core/app-menu.js" type="text/javascript"></script>
  <script src="../../../app-assets/js/core/app.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="../../../app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
  <script src="../../../app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>