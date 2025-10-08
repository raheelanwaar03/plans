@extends('admin.layout.app')

@section('content')
    <div class="startbar-overlay d-print-none"></div>
    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                            <h4 class="page-title">Email Marketing</h4>
                            <div class="">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Admin.Dashboard') }}">{{ env('APP_NAME') }}</a>
                                    </li><!--end nav-item-->
                                    <li class="breadcrumb-item active">Emails</li>
                                </ol>
                            </div>
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Email Marketing</h4>
                                    </div>
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Email.Marketing.Content') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label>Subject</label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Message</label>
                                        <textarea name="message" rows="8" class="form-control" required></textarea>
                                    </div>

                                    <button class="btn btn-primary">Send Email</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div><!-- container -->

            <footer class="footer text-center text-sm-start d-print-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-0 rounded-bottom-0">
                                <div class="card-body">
                                    <p class="text-muted mb-0">
                                        ©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script>
                                        {{ env('APP_NAME') }}
                                        <span class="text-muted d-none d-sm-inline-block float-end">
                                            Design with
                                            <i class="iconoir-heart-solid text-danger align-middle"></i>
                                            by {{ env('APP_NAME') }}'s Team</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
