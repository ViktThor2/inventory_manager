@extends('layouts.app')

@section('content')

    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Felhasználók
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            {{--
                            <thead style="font-size: 16px">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Companies</th>
                            </tr>
                            </thead>
                                <tr>
                                    <td><input type="text" class="form-control filter-input"
                                               placeholder="Keresés..." data-column="0" /></td>
                                    <td><input type="text" class="form-control filter-input"
                                               placeholder="Keresés..." data-column="1" /></td>
                                    <td><input type="text" class="form-control filter-input"
                                               placeholder="Keresés..." data-column="2" /></td>
                                    <td><input type="text" class="form-control filter-input"
                                               placeholder="Keresés..." data-column="3" /></td>
                                    <td><input type="text" class="form-control filter-input"
                                               placeholder="Keresés..." data-column="4" /></td>
                                </tr>
                            --}}

                            <thead>
                                <tr style="font-size: 18px">
                                    <th class="align-middle">Id</th>
                                    <th class="align-middle">Név</th>
                                    <th class="align-middle">Email</th>
                                    <th class="align-middle">Szerep</th>
                                    <th class="align-middle">Cégek</th>
                                </tr>
                            </thead>

                            <thead>
                                <tr style="font-size: 18px">
                                    <th class="align-middle">Id</th>
                                    <th class="align-middle">Név</th>
                                    <th class="align-middle">Email</th>
                                    <th class="align-middle">Szerep</th>
                                    <th class="align-middle">Cégek</th>

                                    <th style="padding: 2px" class="align-middle"  width="100">
                                        <button style="float: right; font-weight: 900;" class="btn btn-success w-100" type="button"  data-toggle="modal" data-target="#CreateUserModal">
                                            <i class="fas fa-plus fa-sm"></i>Új
                                        </button>
                                    </th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create  Modal -->
        <div class="modal" id="CreateUserModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Felhasználó létrehozása</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>Siker! </strong>Felhasználó létrehozva.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="name">Név:</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Jelszó:</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password">Jelszó megerősítése:</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                        <div class="form-group">
                            <select class="form-control select2" name="companies[]" id="companies" multiple>
                                <option value=""  selected>Kérem válasszon céget</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control select2" name="role_id" id="role_id" >
                            <option value=""  selected>Kérem válasszon szerepkört</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitCreateUserForm">Mentés</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Bezár</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit  Modal -->
        <div class="modal" id="EditUserModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Felhasználó szerkesztése</h4>
                        <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="EditUserModalBody">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>Siker!</strong>Felhasználó frissítve.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitEditUserForm">Mentés</button>
                        <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Bezár</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete  Modal -->
        <div class="modal" id="DeleteUserModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Felhasználó törlése</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h4>Biztos, hogy törölni szeretnéd a felhasználót?</h4>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitDeleteUserForm">Igen</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Nem</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script type="text/javascript">
            $(document).ready(function() {

                // init datatable.
                var dataTable = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 50,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: {
                        url: '{{ route('get-user') }}'
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'Role', name: 'Role'},
                        {data: 'Companies', name: 'Companies'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                    ],

                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var input = document.createElement("input");
                            $(input).appendTo($(column.header()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                        });
                    }

                });


                // Create article Ajax request.
                $('#SubmitCreateUserForm').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('user.store') }}",
                        method: 'post',
                        data: {
                            name: $('#name').val(),
                            email: $('#email').val(),
                            password: $('#password').val(),
                            password_confirmation: $('#password_confirmation').val(),
                            role_id: $('#role_id').val(),
                            companies: $('#companies').val(),
                        },
                        success: function(result) {
                            if(result.errors) {
                                $('.alert-danger').html('');
                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                });
                            } else {
                                $('.alert-danger').hide();
                                $('.alert-success').show();
                                $('.datatable').DataTable().ajax.reload();
                                setInterval(function(){
                                    $('.alert-success').hide();
                                    $('#CreateUserModal').modal('hide');
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                });

                // Update  Ajax request.
                $('#SubmitEditUserForm').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "user/"+id,
                        method: 'PUT',
                        data: {
                            name: $('#editName').val(),
                            email: $('#editemail').val(),
                            password: $('#editPassword').val(),
                            password_confirmation: $('#editPassword_confirmation').val(),
                            role_id: $('#editRole_id').val(),
                            companies: $('#editCompanies').val(),


                        },
                        success: function(result) {
                            if(result.errors) {
                                $('.alert-danger').html('');
                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                });
                            } else {
                                $('.alert-danger').hide();
                                $('.alert-success').show();
                                location.reload();
                                setInterval(function(){
                                    $('.alert-success').hide();
                                    $('#EditUserModal').hide();
                                }, 2000);
                            }
                        }
                    });
                });

                // Get single article in EditModel
                $('.modelClose').on('click', function(){
                    $('#EditUserModal').hide();
                });
                var id;
                $('body').on('click', '#getEditUserData', function(e) {
                    // e.preventDefault();
                    $('.alert-danger').html('');
                    $('.alert-danger').hide();
                        id = $(this).data('id');
                    $.ajax({
                        url: "user/"+id+"/edit",
                        method: 'GET',
                        // data: {
                        //     id: id,
                        // },
                        success: function(result) {
                            console.log(result);
                            $('#EditUserModalBody').html(result.html);
                            $('#EditUserModal').show();
                        }
                    });
                });


                // Delete  request.
                var deleteID;
                $('body').on('click', '#getDeleteId', function(){
                    deleteID = $(this).data('id');
                })
                $('#SubmitDeleteUserForm').click(function(e) {
                    e.preventDefault();
                    var id = deleteID;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "user/"+id,
                        method: 'DELETE',
                        success: function(result) {
                            setInterval(function(){
                                location.reload();
                                $('#DeleteUserModal').hide();
                            }, 1000);
                        }
                    });
                });

            });
        </script>
    @endsection
