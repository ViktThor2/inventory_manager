@extends('layouts.app')

@section('content')


    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Jogosultságok
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle" width="40">Id</th>
                                <th class="align-middle">Jogosultság</th>

                                <th style="padding: 2px" class="align-middle"  width="140">
                                    <button style="float: right; font-weight: 900;" class="btn btn-success w-100" type="button"  data-toggle="modal" data-target="#CreatePermissionModal">
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
    <div class="modal" id="CreatePermissionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Jogosultság létrehozása</h4>
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
                        <strong>Siker! </strong>Jogosultság létrehozva.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="name">Jogosultság:</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitCreatePermissionForm">Mentés</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->

    <div class="modal" id="EditPermissionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Jogosultság szerkesztése</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="EditPermissionModalBody">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Siker!</strong>Jogosultság frissítve.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditPermissionForm">Mentés</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete  Modal -->
    <div class="modal" id="DeletePermissionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Jogosultság törlése</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4>Biztos, hogy törölni szeretnéd a jogosultságot?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitDeletePermissionForm">Igen</button>
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
                ajax: '{{ route('get-permission') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ],
            });

            // Create article Ajax request.
            $('#SubmitCreatePermissionForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('permission.store') }}",
                    method: 'post',
                    data: {
                        name: $('#name').val(),
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
                                $('#CreatePermissionModal').modal('hide');
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });

            // Update  Ajax request.
            $('#SubmitEditPermissionForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "permission/"+id,
                    method: 'PUT',
                    data: {
                        name: $('#editName').val(),
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
                                $('#EditPermissionModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

            // Get single article in EditModel
            $('.modelClose').on('click', function(){
                $('#EditPermissionModal').hide();
            });
            var id;
            $('body').on('click', '#getEditPermissionData', function(e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "permission/"+id+"/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        console.log(result);
                        $('#EditPermissionModalBody').html(result.html);
                        $('#EditPermissionModal').show();
                    }
                });
            });


            // Delete  request.
            var deleteID;
            $('body').on('click', '#getDeleteId', function(){
                deleteID = $(this).data('id');
            })
            $('#SubmitDeletePermissionForm').click(function(e) {
                e.preventDefault();
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "permission/"+id,
                    method: 'DELETE',
                    success: function(result) {
                        setInterval(function(){
                            location.reload();
                            $('#DeletePermissionModal').hide();
                        }, 1000);
                    }
                });
            });

        });
    </script>
@endsection
