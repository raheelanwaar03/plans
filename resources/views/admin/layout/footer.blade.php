<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Add User Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user text-muted thumb-xl rounded me-2 border-dashed"></i>
                        <div class="flex-grow-1 text-truncate">
                            <label class="btn btn-primary text-light">
                                Add Avatar <input type="file" hidden="">
                            </label>
                        </div><!--end media body-->
                    </div>
                </div>
                <div class=" mb-2">
                    <label for="fullName">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text" id="fullName"><i class="far fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Name" aria-label="FullName">
                    </div>
                </div>
                <div class=" mb-2">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <span class="input-group-text" id="email"><i class="far fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="Email address" aria-label="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="ragisterDate">Register Date</label>
                            <div class="input-group">
                                <span class="input-group-text" id="ragisterDate"><i class="far fa-calendar"></i></span>
                                <input type="text" class="form-control" placeholder="00/2024"
                                    aria-label="ragisterDate">
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="mobilleNo">Mobille No</label>
                            <div class="input-group">
                                <span class="input-group-text" id="mobilleNo"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" placeholder="+1 234 567 890"
                                    aria-label="mobilleNo">
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100">Add User</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
