<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">


<!-- Mirrored from mannatthemes.com/approx/default/users.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Feb 2025 18:15:05 GMT -->

<head>


    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }}| Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">


    <link href="{{ asset('assets/libs/simple-datatables/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="topbar d-print-none">
        <div class="container-fluid">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu"></i>
                        </button>
                    </li>
                    <li class="hide-phone app-search">
                        <form role="search" action="#" method="get">
                            <input type="search" name="search" class="form-control top-search mb-0"
                                placeholder="Search here...">
                            <button type="submit"><i class="iconoir-search"></i></button>
                        </form>
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li class="topbar-item">
                        <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                            <i class="iconoir-half-moon dark-mode"></i>
                            <i class="iconoir-sun-light light-mode"></i>
                        </a>
                    </li>
                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt=""
                                class="thumb-md rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt=""
                                        class="thumb-md rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                    <h6 class="my-0 fw-medium text-dark fs-13">William Martin</h6>
                                    <small class="text-muted mb-0">Admin</small>
                                </div><!--end media-body-->
                            </div>
                            <div class="dropdown-divider mt-0"></div>
                            <small class="text-muted px-2 pb-1 d-block">Account</small>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="las la-user fs-18 me-1 align-text-bottom"></i> Profile</a>
                            {{-- make a logout function in javascript --}}
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul><!--end topbar-nav-->
            </nav>
            <!-- end navbar-->
        </div>
    </div>
    <div class="startbar d-print-none">
        <!--start brand-->
        <div class="brand">
            <a href="index.html" class="logo">
                <span>
                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
                </span>
                <span class="">
                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-large" class="logo-lg logo-light">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
                </span>
            </a>
        </div>
        <!--end brand-->
        <!--start startbar-menu-->
        <div class="startbar-menu">
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-auto w-100">
                        <li class="menu-label mt-2">
                            <span>Main</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.Dashboard') }}">
                                <i class="iconoir-report-columns menu-icon"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.KYC.Requests') }}">
                                <i class="iconoir-community menu-icon"></i>
                                {{-- <i class="iconoir-hand-cash menu-icon"></i> --}}
                                <span>KYC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.ContactUs.Request') }}">
                                <i class="iconoir-task-list menu-icon"></i>
                                <span>Contact Us</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.Premium.Requests') }}">
                                <i class="iconoir-credit-cards menu-icon"></i>
                                <span>Premium</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="taxes.html">
                                <i class="iconoir-plug-type-l menu-icon"></i>
                                <span>Texes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.html">
                                <i class="iconoir-group menu-icon"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-chat.html">
                                <i class="iconoir-chat-bubble menu-icon"></i>
                                <span>Chat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-contact-list.html">
                                <i class="iconoir-community menu-icon"></i>
                                <span>Contact List</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-calendar.html">
                                <i class="iconoir-calendar menu-icon"></i>
                                <span>Calendar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="apps-invoice.html">
                                <i class="iconoir-paste-clipboard menu-icon"></i>
                                <span>Invoice</span>
                            </a>
                        </li>
                        <li class="menu-label mt-2">
                            <small class="label-border">
                                <div class="border_left hidden-xs"></div>
                                <div class="border_right"></div>
                            </small>
                            <span>Components</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarElements">
                                <i class="iconoir-compact-disc menu-icon"></i>
                                <span>UI Elements</span>
                            </a>
                            <div class="collapse " id="sidebarElements">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-alerts.html">Alerts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-avatar.html">Avatar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-buttons.html">Buttons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-badges.html">Badges</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-cards.html">Cards</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-carousels.html">Carousels</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-dropdowns.html">Dropdowns</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-grids.html">Grids</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-images.html">Images</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-list.html">List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-modals.html">Modals</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-navs.html">Navs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-navbar.html">Navbar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-paginations.html">Paginations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-popover-tooltips.html">Popover & Tooltips</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-progress.html">Progress</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-spinners.html">Spinners</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-tabs-accordions.html">Tabs & Accordions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-typography.html">Typography</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ui-videos.html">Videos</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarElements-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarAdvancedUI">
                                <i class="iconoir-peace-hand menu-icon"></i>
                                <span>Advanced UI</span><span
                                    class="badge rounded text-success bg-success-subtle ms-1">New</span>
                            </a>
                            <div class="collapse " id="sidebarAdvancedUI">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-animation.html">Animation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-clipboard.html">Clip Board</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-dragula.html">Dragula</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-files.html">File Manager</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-highlight.html">Highlight</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-rangeslider.html">Range Slider</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-ratings.html">Ratings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-ribbons.html">Ribbons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-sweetalerts.html">Sweet Alerts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="advanced-toasts.html">Toasts</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarAdvancedUI-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarForms">
                                <i class="iconoir-cube-hole menu-icon"></i>
                                <span>Forms</span>
                            </a>
                            <div class="collapse " id="sidebarForms">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-elements.html">Basic Elements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-advanced.html">Advance Elements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-validation.html">Validation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-wizard.html">Wizard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-editors.html">Editors</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-uploads.html">File Upload</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="forms-img-crop.html">Image Crop</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarForms-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCharts">
                                <i class="iconoir-candlestick-chart menu-icon"></i>
                                <span>Charts</span>
                            </a>
                            <div class="collapse " id="sidebarCharts">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-apex.html">Apex</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-justgage.html">JustGage</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-chartjs.html">Chartjs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="charts-toast-ui.html">Toast</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarCharts-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarTables">
                                <i class="iconoir-list menu-icon"></i>
                                <span>Tables</span>
                            </a>
                            <div class="collapse " id="sidebarTables">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-basic.html">Basic</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-datatable.html">Datatables</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="tables-editable.html">Editable</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarTables-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarIcons">
                                <i class="iconoir-fire-flame menu-icon"></i>
                                <span>Icons</span>
                            </a>
                            <div class="collapse " id="sidebarIcons">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-fontawesome.html">Font Awesome</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-lineawesome.html">Line Awesome</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-icofont.html">Icofont</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="icons-iconoir.html">Iconoir</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarIcons-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarMaps">
                                <i class="iconoir-map-pin menu-icon"></i>
                                <span>Maps</span>
                            </a>
                            <div class="collapse " id="sidebarMaps">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-google.html">Google Maps</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-leaflet.html">Leaflet Maps</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="maps-vector.html">Vector Maps</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarMaps-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarEmailTemplates" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarEmailTemplates">
                                <i class="iconoir-send-mail menu-icon"></i>
                                <span>Email Templates</span>
                            </a>
                            <div class="collapse " id="sidebarEmailTemplates">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-basic.html">Basic Action Email</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-alert.html">Alert Email</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="email-templates-billing.html">Billing Email</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarEmailTemplates-->
                        </li>
                        <li class="menu-label mt-2">
                            <small class="label-border">
                                <div class="border_left hidden-xs"></div>
                                <div class="border_right"></div>
                            </small>
                            <span>Crafted</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarPages">
                                <i class="iconoir-page-star menu-icon"></i>
                                <span>Pages</span>
                            </a>
                            <div class="collapse " id="sidebarPages">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-profile.html">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-notifications.html">Notifications</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-timeline.html">Timeline</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-treeview.html">Treeview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-starter.html">Starter Page</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-pricing.html">Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-blogs.html">Blogs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-faq.html">FAQs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-gallery.html">Gallery</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarPages-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarAuthentication" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                                <i class="iconoir-fingerprint-lock-circle menu-icon"></i>
                                <span>Authentication</span>
                            </a>
                            <div class="collapse " id="sidebarAuthentication">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-login.html">Log in</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-register.html">Register</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-recover-pw.html">Re-Password</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-lock-screen.html">Lock Screen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-maintenance.html">Maintenance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-404.html">Error 404</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="auth-500.html">Error 500</a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end startbarAuthentication-->
                        </li> --}}
                    </ul>
                </div>
            </div><!--end startbar-collapse-->
        </div><!--end startbar-menu-->
    </div>
