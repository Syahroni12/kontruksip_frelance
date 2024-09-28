@include('templating_admin.header')

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-50">
        <div class="row justify-content-center w-100">
          <div class="col-md-6 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <div class="text-center">
                <i class="fa-solid fa-user-tie fa-3x"></i>
        
                <br>
                Daftar sebagai penyedia jasa
                <a href="" class=" btn btn-sm btn-primary">daftar</a >
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <div class="text-center">
                <i class="fa-solid fa-user fa-3x"></i>
                <br>
                Daftar sebagai  customer
                <a href="{{ route('register_customer') }}" class=" btn btn-sm btn-primary">daftar</a>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('templating_admin.footer_js')