@extends('layouts.app')

@section('content')
<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        @include('layouts.breadcrumb')
      </div>
    </div>
    <!-- end page title -->

      

      <div class="row">
          {{-- <div class="col-xl-6">

              <div class="card">
                  <div class="card-body pb-0">
                      <div class="float-end d-none d-md-inline-block">
                          <div class="dropdown card-header-dropdown">
                              <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end">
                                  <a class="dropdown-item" href="#">Export</a>
                                  <a class="dropdown-item" href="#">Import</a>
                                  <a class="dropdown-item" href="#">Download Report</a>
                              </div>
                          </div>
                      </div>
                      <h4 class="card-title mb-4">Email Sent</h4>

                      <div class="text-center pt-3">
                          <div class="row">
                              <div class="col-sm-4 mb-3 mb-sm-0">
                                  <div class="d-inline-flex">
                                      <h5 class="me-2">25,117</h5>
                                      <div class="text-success font-size-12">
                                          <i class="mdi mdi-menu-up font-size-14"> </i>2.2 %
                                      </div>
                                  </div>
                                  <p class="text-muted text-truncate mb-0">Marketplace</p>
                              </div><!-- end col -->
                              <div class="col-sm-4 mb-3 mb-sm-0">
                                  <div class="d-inline-flex">
                                      <h5 class="me-2">$34,856</h5>
                                      <div class="text-success font-size-12">
                                          <i class="mdi mdi-menu-up font-size-14"> </i>1.2 %
                                      </div>
                                  </div>
                                  <p class="text-muted text-truncate mb-0">Last Week</p>
                              </div><!-- end col -->
                              <div class="col-sm-4">
                                  <div class="d-inline-flex">
                                      <h5 class="me-2">$18,225</h5>
                                      <div class="text-success font-size-12">
                                          <i class="mdi mdi-menu-up font-size-14"> </i>1.7 %
                                      </div>
                                  </div>
                                  <p class="text-muted text-truncate mb-0">Last Month</p>
                              </div><!-- end col -->
                          </div><!-- end row -->
                      </div>
                  </div>
                  <div class="card-body py-0 px-2">
                      <div id="area_chart" class="apex-charts" dir="ltr"></div>
                  </div>
              </div><!-- end card -->
          </div>
          <!-- end col -->
          <div class="col-xl-6">
              <div class="card">
                  <div class="card-body pb-0">
                      <div class="float-end d-none d-md-inline-block">
                          <div class="dropdown">
                              <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="text-muted">This Years<i class="mdi mdi-chevron-down ms-1"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end">
                                  <a class="dropdown-item" href="#">Today</a>
                                  <a class="dropdown-item" href="#">Last Week</a>
                                  <a class="dropdown-item" href="#">Last Month</a>
                                  <a class="dropdown-item" href="#">This Year</a>
                              </div>
                          </div>
                      </div>
                      <h4 class="card-title mb-4">Revenue</h4>

                      <div class="text-center pt-3">
                          <div class="row">
                              <div class="col-sm-4 mb-3 mb-sm-0">
                                  <div>
                                      <h5>17,493</h5>
                                      <p class="text-muted text-truncate mb-0">Marketplace</p>
                                  </div>
                              </div><!-- end col -->
                              <div class="col-sm-4 mb-3 mb-sm-0">
                                  <div>
                                      <h5>$44,960</h5>
                                      <p class="text-muted text-truncate mb-0">Last Week</p>
                                  </div>
                              </div><!-- end col -->
                              <div class="col-sm-4">
                                  <div>
                                      <h5>$29,142</h5>
                                      <p class="text-muted text-truncate mb-0">Last Month</p>
                                  </div>
                              </div><!-- end col -->
                          </div><!-- end row -->
                      </div>
                  </div>
                  <div class="card-body py-0 px-2">
                      <div id="column_line_chart" class="apex-charts" dir="ltr"></div>
                  </div>
              </div><!-- end card -->
          </div> --}}
          <!-- end col -->
      </div>
      <!-- end row -->

  </div>
  
</div>
<!-- End Page-content -->
@endsection