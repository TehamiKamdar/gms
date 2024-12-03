<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="fas fa-ellipsis-h nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-home"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="fas fa-ellipsis-h nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">UI COMPONENTS</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('membership-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <span class="hide-menu">Membership</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('specialization-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <span class="hide-menu">Specialization</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('members-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="hide-menu">Members</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('trainers-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-dumbbell"></i>
                                </span>
                                <span class="hide-menu">Trainers</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('classes-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </span>
                                <span class="hide-menu">Classes</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('payment-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-wallet"></i>
                                </span>
                                <span class="hide-menu">Payments</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('transaction-index') }}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-wallet"></i>
                                </span>
                                <span class="hide-menu">Transactions</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('enrollment-index')}}" aria-expanded="false">
                                <span>
                                    <i class="fas fa-user-plus"></i>
                                </span>
                                <span class="hide-menu">Enrollments</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="fas fa-ellipsis-h nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">AUTH</span>
                        </li>
                        @if (Route::has('login'))

                            @auth
                                <li class="sidebar-item">
                                    <!-- Modal Trigger -->
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <span>
                                            <i class="fas fa-sign-out-alt"></i>
                                        </span>
                                        <span class="hide-menu">Log Out</span>
                                    </button>
                                </li>
                            

                                <!-- Modal -->
                                <div class="modal fade"  id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to log out?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Log Out</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                            @endauth
                        @endif
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header End -->
            <div class="container-fluid">