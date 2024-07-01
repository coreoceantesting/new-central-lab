<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="50" />
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="50" />
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu">Menu</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                @canany(['masters.all'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Masters</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts1">
                        <ul class="nav nav-sm flex-column">
                            {{-- <li class="nav-item">
                                <a href="{{ route('wards.index') }}" class="nav-link" data-key="t-horizontal">Wards</a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('labs.index') }}" class="nav-link" data-key="t-horizontal">Labs</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('maincategories.index') }}" class="nav-link" data-key="t-horizontal">Main Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subcategories.index') }}" class="nav-link" data-key="t-horizontal">Sub Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('methods.index') }}" class="nav-link" data-key="t-horizontal">Method</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan


                @canany(['users.view', 'roles.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-layouts">User Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts2">
                        <ul class="nav nav-sm flex-column">
                            @can('users.view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link" data-key="t-horizontal">Users</a>
                                </li>
                            @endcan
                            @can('roles.view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link" data-key="t-horizontal">Roles</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['patient.Registration'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayoutsnew" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                            <i class="bx bx-user-circle"></i>
                            <span data-key="t-layouts">Patient Registration</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayoutsnew">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('register.patient.create') }}" class="nav-link" data-key="t-horizontal">New Patient Registration</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('register.patient.list') }}" class="nav-link" data-key="t-horizontal">Registrared Patient List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('register.patient') }}" >
                            <i class="ri-user-line"></i>
                            <span data-key="t-dashboards">Patient Registration</span>
                        </a>
                    </li> --}}
                @endcan


                @canany(['list.PendingForReceive', 'list.RejectedSample'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayouts3" data-bs-toggle="collapse" role="button">
                            <i class="bx bx-file-find"></i>
                            <span data-key="t-layouts">Sample Sent To Lab</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayouts3">
                            <ul class="nav nav-sm flex-column">
                                @can('list.PendingForReceive')
                                    <li class="nav-item">
                                        <a href="{{ route('pending_for_receive.patient') }}" class="nav-link" data-key="t-dashboards">Pending To Receive Sample List</a>
                                    </li>
                                @endcan
                                @can('list.RejectedSample')
                                    <li class="nav-item">
                                        <a href="{{ route('rejected_sample_list') }}" class="nav-link" data-key="t-dashboards">Rejected sample list</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan


                @canany(['list.ReceivedSample', 'list.ApprovedSample'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayouts4" data-bs-toggle="collapse" role="button">
                            <i class="bx bx-scatter-chart"></i>
                            <span data-key="t-layouts">Receive sample</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayouts4">
                            <ul class="nav nav-sm flex-column">
                                @can('list.ReceivedSample')
                                    <li class="nav-item">
                                        <a href="{{ route('pending_for_received_sample_list') }}" class="nav-link" data-key="t-dashboards">Pending For Receive Sample</a>
                                    </li>
                                @endcan
                                @can('list.ApprovedSample')
                                    <li class="nav-item">
                                        <a href="{{ route('received_sample_list') }}" class="nav-link" data-key="t-dashboards">Received Sample</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @canany(['list.ReceivedSample', 'list.ApprovedSample'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayouts12" data-bs-toggle="collapse" role="button">
                            <i class="bx bx-scatter-chart"></i>
                            <span data-key="t-layouts">Sample Quality Verification</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayouts12">
                            <ul class="nav nav-sm flex-column">
                                @can('list.ReceivedSample')
                                    <li class="nav-item">
                                        <a href="{{ route('quality_check_list') }}" class="nav-link" data-key="t-dashboards">Pending for Quality Check</a>
                                    </li>
                                @endcan
                                @can('list.ApprovedSample')
                                    <li class="nav-item">
                                        <a href="{{ route('patient_approved_list') }}" class="nav-link" data-key="t-dashboards">Approved Sample</a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a href="{{ route('patient_rejected_list') }}" class="nav-link" data-key="t-dashboards">Rejected Sample</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('approved_sample_list') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">In-process Sample List</span>
                    </a>
                </li>


                {{-- @canany(['list.ReceivedSample'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('received_sample_list') }}" >
                            <i class="ri-file-list-line"></i>
                            <span data-key="t-dashboards">Received Sample List</span>
                        </a>
                    </li>
                @endcan

                @canany(['list.ApprovedSample'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('approved_sample_list') }}" >
                            <i class="ri-list-check"></i>
                            <span data-key="t-dashboards">Approved Sample List</span>
                        </a>
                    </li>
                @endcan --}}

                @canany(['list.FirstVerification'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('first_verification_list') }}" >
                            <i class="ri-list-check"></i>
                            <span data-key="t-dashboards">First Verification List</span>
                        </a>
                    </li>
                @endcan

                @canany(['list.SecondVerification'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('second_verification_list') }}" >
                            <i class="ri-list-check"></i>
                            <span data-key="t-dashboards">Second Verification List</span>
                        </a>
                    </li>
                @endcan

                @canany(['list.DoctorRejected'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('doctor_rejected_list') }}" >
                            <i class="ri-list-check"></i>
                            <span data-key="t-dashboards">Doctor Rejected List</span>
                        </a>
                    </li>
                @endcan

                @canany(['list.GenratedReport'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('generated_report_list') }}" >
                            <i class="ri-list-check"></i>
                            <span data-key="t-dashboards">Generated Report List</span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>


<div class="vertical-overlay"></div>
