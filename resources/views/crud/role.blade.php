@extends('layouts.app')

@section('content')


    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Szerepek
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle" width="40">Id</th>
                                <th class="align-middle">Szerep</th>
                                <th class="align-middle">Jogosultások</th>
                                <th style="padding: 2px" class="align-middle"  width="140">
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->
    <div class="modal" id="EditRoleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Szerep szerkesztése</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="EditRoleModalBody">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Siker!</strong>Szerep frissítve.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditRoleForm">Mentés</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete  Modal -->
    <div class="modal" id="DeleteRoleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Szerep törlése</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4>Biztos, hogy törölni szeretnéd ?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitDeleteRoleForm">Igen</button>
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
                ajax: '{{ route('get-role') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'Permission', name: 'Permission'},
                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ],
            });

            // Update  Ajax request.
            $('#SubmitEditRoleForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "role/"+id,
                    method: 'PUT',
                    data: {
                        permissions: $('#editPermissions').val(),
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
                                $('#EditRoleModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

            // Get single article in EditModel
            $('.modelClose').on('click', function(){
                $('#EditRoleModal').hide();
            });
            var id;
            $('body').on('click', '#getEditRoleData', function(e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "role/"+id+"/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        console.log(result);
                        $('#EditRoleModalBody').html(result.html);
                        $('#EditRoleModal').show();
                    }
                });
            });


            // Delete  request.
            var deleteID;
            $('body').on('click', '#getDeleteId', function(){
                deleteID = $(this).data('id');
            })
            $('#SubmitDeleteRoleForm').click(function(e) {
                e.preventDefault();
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "role/"+id,
                    method: 'DELETE',
                    success: function(result) {
                        setInterval(function(){
                            location.reload();
                            $('#DeleteRoleModal').hide();
                        }, 1000);
                    }
                });
            });

        });
    </script>
@endsection
