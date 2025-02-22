<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="main-url" content="{{ url('/') }}" />

    <title>@yield('title') | dashboard</title>
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css" />
    <link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css" />

    <!-- toastr css -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> --}}
    <link rel="stylesheet" href="{{ static_asset('css/toastr.min.css') }}">

    <!-- vanilla clendar -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ static_asset('css/vanilla-calendar.min.css') }}"> --}}

    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />

    <link rel="stylesheet" href="{{ static_asset('css/custome.css') }}">
    @yield('style')
    @stack('style')
  </head>
  <body>
    <div class="container-scroller">

      {{-- include side Bare --}}
      @include('food.partials.sidebar')

      <div class="container-fluid page-body-wrapper">
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close mdi mdi-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-default-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div> Default
          </div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div> Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles light"></div>
            <div class="tiles dark"></div>
          </div>
        </div>

        {{-- top bar --}}
        @include('food.partials.topbar')

        <div class="main-panel">
          
          @yield('content')

          <!-- list of upload files in background -->
          <div class="accordion attempUpload mb-2" id="accordionAttempUpload">
            <div class="accordion-item">
                <h2 class="accordion-header mb-0 p-2 d-flex" id="headingOne">
                  <button class="accordion-button p-0" type="button" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapseOne">
                    Files Upload
                  </button>
                  <button class="btn btn-sm close-uploaded">
                    <i class="mdi mdi-close text-danger"></i>
                    {{-- <span aria-hidden="true">&times;</span> --}}
                  </button>
                </h2>
        
                <div id="collapsetwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionAttempUpload">
                    <div class="accordion-body">
                        <div id="" class="media-upload media-are-upload"></div>
                    </div>
                </div>
            </div>
          </div>

          <footer class="footer">
            <div class="text-center">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © All rights reserved at <a href="#">Hanini Food</a>, Réaliser par <a href="http://badnitech.com">BadniTech</a> </span>
              {{-- <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard template</a> from Bootstrapdash.com</span> --}}
            </div>
          </footer>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/vendors/select2/select2.min.js"></script>
    <script src="/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/typeahead.js"></script>
    <script src="/assets/js/select2.js"></script>

    <script src="/assets/js/file-upload.js"></script>
    <script src="{{ static_asset('js/helper.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script> --}}
    <script src="{{ static_asset('js/resumable.min.js') }}"></script>
    
    <!-- toastr js -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
    <script src="{{ static_asset('js/toastr.min.js')  }}"></script>
    <!-- moment js -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script> --}}
    <script src="{{ static_asset('js/moment.min.js') }}"></script>
    <!-- vanilla calendar -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script> --}}
    <script src="{{ static_asset('js/vanilla-calendar.min.js') }}"></script>

    {{-- <script src="{{ static_asset('js/sweetalert211.min.js') }}"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script src="{{ static_asset('js/main.js') }}"></script>

    <!-- init post ajax -->
    <script>
        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept' : 'application/json',
                },
        });

        (function($, window) {
            //is onprogress supported by browser?
            var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());

            //If not supported, do nothing
            if (!hasOnProgress) {
                return;
            }
            
            //patch ajax settings to call a progress callback
            var oldXHR = $.ajaxSettings.xhr;
            $.ajaxSettings.xhr = function() {
                var xhr = oldXHR.apply(this, arguments);
                if(xhr instanceof window.XMLHttpRequest) {
                    xhr.addEventListener('progress', this.progress, false);
                }
                
                if(xhr.upload) {
                    xhr.upload.addEventListener('progress', this.progress, false);
                }
                
                return xhr;
            };

            $('.close-uploaded').click(e=>{
              if(!isUploading){
                $('.attempUpload').css('display', 'none')
                $('.media-are-upload').html('');
              }
            })
          })(jQuery, window);

    </script>
    @yield('script')
    @stack('script')

    {!! Toastr::message();  !!}
  </body>
</html>