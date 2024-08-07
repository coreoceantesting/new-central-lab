<x-admin.layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="heading">Dashboard</x-slot>
    {{-- <x-slot name="subheading">Test</x-slot> --}}

    {{-- new dashboard --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="d-flex flex-column h-100">
                <div class="row">
                    {{-- @canany(['dashboard.Admin', 'dashboard.HealthPost']) --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="card card-animate" id="totalSlipsCardNew">
                                <div class="card-body" style="background-color: lightgreen">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Registered Patient</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i>
                                                    16.24 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="award" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!--end col-->
                    {{-- @endcan --}}

                    {{-- @canany(['dashboard.Admin', 'dashboard.HealthPost']) --}}
                        <div class="col-xl-4 col-md-4">
                            <!-- card -->
                            <div class="card card-animate" id="todaySlipsCardNew">
                                <div class="card-body" style="background-color: lightyellow">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Pending To Receive</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i>
                                                    16.24 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="award" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    {{-- @endcan --}}

                    {{-- @canany(['dashboard.Admin', 'dashboard.HealthPost']) --}}
                        <div class="col-xl-4 col-md-4">
                            <!-- card -->
                            <div class="card card-animate" id="monthlySlipsCardNew">
                                <div class="card-body" style="background-color: skyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                            <b>Rejected Sample</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-danger mb-0">
                                                    <i class="ri-arrow-down-line align-middle"></i>
                                                    3.96 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="box" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    {{-- @endcan --}}
                    
                    {{-- @canany(['dashboard.Admin', 'dashboard.HealthPost']) --}}
                        <div class="col-xl-4 col-md-4">
                            <!-- card -->
                            <div class="card card-animate" id="yearlySlipsCardNew">
                                <div class="card-body" style="background-color: rgb(43, 218, 165)">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Generated Report</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-danger mb-0">
                                                    <i class="ri-arrow-down-line align-middle"></i>
                                                    0.24 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="list" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    {{-- @endcan --}}
                    
                    {{-- @canany(['dashboard.Admin', 'dashboard.HealthPost']) --}}
                        <div class="col-xl-4 col-md-4">
                            {{-- card --}}
                            <div class="card card-animate" id="actiontakenSlipsNew" style="background-color: rgb(241, 166, 84)">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Resampling</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!--end col-->
                    {{-- @endcan --}}

                    {{-- @canany(['dashboard.Admin', 'dashboard.LabTechnician']) --}}
                        <div class="col-xl-4 col-md-4">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Pending For Receive</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    {{-- @endcan --}}

                    @canany(['dashboard.Admin', 'dashboard.LabTechnician'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Received Sample</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.LabTechnician'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Approved Sample</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.LabTechnician'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Rejected Sample</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.LabTechnician'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>In Process Sample</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.LabTechnician'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Doctor Reject</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.Doctor'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>First Verification</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.Doctor'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Second Verification</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                    @canany(['dashboard.Admin', 'dashboard.Doctor'])
                        <div class="col-xl-4 col-md-4 d-none">
                            <!-- card -->
                            <div class="card card-animate" id="vardiahavalSlipsCardNew">
                                <div class="card-body" style="background-color: deepskyblue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="fw-medium text-dark mb-0">
                                                <b>Generated Verification</b>
                                            </a>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value text-primary" data-target="0">0</span>
                                            </h2>
                                            <p class="mb-0 text-muted" style="display: none">
                                                <span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i>
                                                    7.05 %
                                                </span>
                                                vs. previous
                                                month
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0 d-none">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="file-text" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card-->
                        </div><!-- end col -->
                    @endcan

                </div><!--end row-->
            </div>
        </div><!--end col-->



    {{-- <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">
                <div class="row h-100 d-none">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                    <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                    <div class="flex-grow-1 text-truncate">
                                        Your free trial
                                        expired in
                                        <b>17</b> days.
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                    </div>
                                </div>

                                <div class="row align-items-end">
                                    <div class="col-sm-8">
                                        <div class="p-3">
                                            <p class="fs-16 lh-base">
                                                Upgrade your
                                                plan from a
                                                <span class="fw-semibold">Free
                                                    trial</span>, to
                                                ‘Premium
                                                Plan’
                                                <i class="mdi mdi-arrow-right"></i>
                                            </p>
                                            <div class="mt-3">
                                                <a href="pages-pricing.html" class="btn btn-success">Upgrade
                                                    Account!</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="px-3">
                                            <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-body-->
                        </div>
                    </div>
                    <!-- end col-->
                </div>

                <div class="row d-none">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">
                                            Users
                                        </p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            <span class="counter-value" data-target="28.05">0</span>k
                                        </h2>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i>
                                                16.24 %
                                            </span>
                                            vs. previous
                                            month
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                <i data-feather="users" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">
                                            Sessions
                                        </p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            <span class="counter-value" data-target="97.66">0</span>k
                                        </h2>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-light text-danger mb-0">
                                                <i class="ri-arrow-down-line align-middle"></i>
                                                3.96 %
                                            </span>
                                            vs. previous
                                            month
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                <i data-feather="activity" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col-->
                </div>

                <div class="row d-none">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">
                                            Avg. Visit
                                            Duration
                                        </p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            <span class="counter-value" data-target="3">0</span>m
                                            <span class="counter-value" data-target="40">0</span>sec
                                        </h2>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-light text-danger mb-0">
                                                <i class="ri-arrow-down-line align-middle"></i>
                                                0.24 %
                                            </span>
                                            vs. previous
                                            month
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                <i data-feather="clock" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">
                                            Bounce Rate
                                        </p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            <span class="counter-value" data-target="33.48">0</span>%
                                        </h2>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-light text-success mb-0">
                                                <i class="ri-arrow-up-line align-middle"></i>
                                                7.05 %
                                            </span>
                                            vs. previous
                                            month
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                <i data-feather="external-link" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col-->
                </div>
            </div>
        </div>

        <div class="col-xxl-7 d-none">
            <div class="row h-100">
                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Live Users By Country
                            </h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-primary btn-sm">
                                    Export Report
                                </button>
                            </div>
                        </div>
                        <!-- end card header -->

                        <!-- card body -->
                        <div class="card-body">
                            <div id="users-by-country" data-colors='["--vz-light"]' class="text-center" style="height: 252px"></div>

                            <div class="table-responsive table-card mt-3">
                                <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                                    <thead class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                                        <tr>
                                            <th>
                                                Duration
                                                (Secs)
                                            </th>
                                            <th style="
                                                    width: 30%;
                                                ">
                                                Sessions
                                            </th>
                                            <th style="
                                                    width: 30%;
                                                ">
                                                Views
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        <tr>
                                            <td>0-30</td>
                                            <td>2,250</td>
                                            <td>4,250</td>
                                        </tr>
                                        <tr>
                                            <td>31-60</td>
                                            <td>1,501</td>
                                            <td>2,050</td>
                                        </tr>
                                        <tr>
                                            <td>61-120</td>
                                            <td>750</td>
                                            <td>1,600</td>
                                        </tr>
                                        <tr>
                                            <td>121-240</td>
                                            <td>540</td>
                                            <td>1,040</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Sessions by Countries
                            </h4>
                            <div>
                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                    ALL
                                </button>
                                <button type="button" class="btn btn-soft-primary btn-sm">
                                    1M
                                </button>
                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                    6M
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div>
                                <div id="countries_charts" data-colors='["--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-danger", "--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-info"]' class="apex-charts" dir="ltr">
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col-->
            </div>
            <!-- end row-->
        </div>
    </div> --}}



    @push('scripts')
    @endpush

</x-admin.layout>
