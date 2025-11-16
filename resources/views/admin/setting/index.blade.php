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
                            <h4 class="page-title">Tokens</h4>
                            <div class="">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('Admin.Dashboard') }}">{{ env('APP_NAME') }}</a>
                                    </li><!--end nav-item-->
                                    <li class="breadcrumb-item active">Token Price</li>
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
                                        <h4 class="card-title text-center">Token Price ({{ $token->price }} pkr)</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Token.Price', $token->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="amount" class="form-label">Token Price</label>
                                                <input type="number" name="price" class="form-control" id="amount"
                                                    value="{{ $token->price }}" step="0.001">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="sell_price" class="form-label">Selling Price</label>
                                                <input type="number" class="form-control" name="selling_price"
                                                    value="{{ $token->selling_price }}" step="0.001">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="buying" class="form-label">Buying Price</label>
                                                <input type="number" name="buying_price" class="form-control"
                                                    id="buying" value="{{ $token->buying_price }}" step="0.001">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="vip_price" class="form-label">VIP Price</label>
                                                <input type="number" class="form-control" name="vip_price"
                                                    value="{{ $token->vip_price }}" step="0.001">
                                            </div>
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
                                        <h4 class="card-title text-center">Password</h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end card-header-->
                            <div class="card-body pt-0">
                                <form action="{{ route('Admin.Update.Password', auth()->user()->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="password">Password Update</label>
                                                <input type="text" id="password" class="form-control" name="password"
                                                    value="{{ auth()->user()->password }}">
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
