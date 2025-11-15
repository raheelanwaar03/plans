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
                            <h4 class="page-title">Update Wallet Details</h4>
                            <div class="">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Admin.Dashboard') }}">{{ env('APP_NAME') }}</a>
                                    </li><!--end nav-item-->
                                    <li class="breadcrumb-item active">Update Wallet Details</li>
                                </ol>
                            </div>
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title text-center">Buy & Sell</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Update.Wallet', $walletDetails->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="amount">Email</label>
                                                <input type="text" id="amount" class="form-control" name="email"
                                                    value="{{ $walletDetails->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="selling_amount">Number</label>
                                                <input type="text" id="selling_amount" class="form-control"
                                                    name="number" value="{{ $walletDetails->number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="buying_amount">Name</label>
                                                <input type="text" id="buying_amount" class="form-control" name="name"
                                                    value="{{ $walletDetails->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="buying_amount">Wallet</label>
                                                <input type="text" id="buying_amount" class="form-control" name="wallet"
                                                    value="{{ $walletDetails->wallet }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title text-center">Premium</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Update.Premium.Wallet', $walletDetails->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="premium_name">Premium Name</label>
                                                <input type="text" id="premium_name" class="form-control"
                                                    name="premium_name" value="{{ $walletDetails->premium_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="premium_number">Premium Number</label>
                                                <input type="text" id="premium_number" class="form-control"
                                                    name="premium_number" value="{{ $walletDetails->premium_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="premium_wallet">Premium Wallet</label>
                                                <input type="text" id="premium_wallet" class="form-control"
                                                    name="premium_wallet" value="{{ $walletDetails->premium_wallet }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title text-center">KYC</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Update.KYC.Wallet', $walletDetails->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kyc_name">Kyc Name</label>
                                                <input type="text" id="kyc_name" class="form-control"
                                                    name="kyc_name" value="{{ $walletDetails->kyc_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kyc_number">Kyc Number</label>
                                                <input type="text" id="kyc_number" class="form-control"
                                                    name="kyc_number" value="{{ $walletDetails->kyc_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kyc_wallet">Kyc Wallet</label>
                                                <input type="text" id="kyc_wallet" class="form-control"
                                                    name="kyc_wallet" value="{{ $walletDetails->kyc_wallet }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title text-center">Lucky</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Update.Lucky.Wallet', $walletDetails->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lucky_name">Lucky Name</label>
                                                <input type="text" id="lucky_name" class="form-control"
                                                    name="lucky_name" value="{{ $walletDetails->lucky_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lucky_number">Lucky Number</label>
                                                <input type="text" id="lucky_number" class="form-control"
                                                    name="lucky_number" value="{{ $walletDetails->lucky_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lucky_wallet">Lucky Wallet</label>
                                                <input type="text" id="lucky_wallet" class="form-control"
                                                    name="lucky_wallet" value="{{ $walletDetails->lucky_wallet }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title text-center">VIP</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Update.VIP.Wallet', $walletDetails->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vip_name">VIP Name</label>
                                                <input type="text" id="vip_name" class="form-control"
                                                    name="vip_name" value="{{ $walletDetails->vip_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vip_number">VIP Number</label>
                                                <input type="text" id="vip_number" class="form-control"
                                                    name="vip_number" value="{{ $walletDetails->vip_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vip_wallet">VIP Wallet</label>
                                                <input type="text" id="vip_wallet" class="form-control"
                                                    name="vip_wallet" value="{{ $walletDetails->vip_wallet }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
