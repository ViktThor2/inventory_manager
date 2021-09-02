@extends('layouts.app')

@section('content')


    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Cégek
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle" width="40">Id</th>
                                <th class="align-middle">Cégnév</th>
                                <th class="align-middle">Adószám</th>
                                <th class="align-middle">Irányítószám</th>
                                <th class="align-middle">Város</th>
                                <th class="align-middle">Cím</th>
                                <th class="align-middle">Kapcs.</th>
                                <th class="align-middle">Nav technikai felhasználónév</th>
                                <th class="align-middle">Nav technikai jelszó</th>
                                <th class="align-middle">Nav technikai aláírás</th>
                                <th class="align-middle">Nav technikai kulcs</th>

                                <th style="padding: 2px" class="align-middle"  width="140">
                                    <button style="float: right; font-weight: 900;" class="btn btn-success w-100" type="button"  data-toggle="modal" data-target="#CreateCompanyModal">
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
    <div class="modal" id="CreateCompanyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cég létrehozása</h4>
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
                        <strong>Siker! </strong>Cég létrehozva.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="name">Cégnév:</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="vat">Adószám:</label>
                        <input type="text" class="form-control" name="vat" id="vat">
                    </div>
                    <div class="form-group">
                        <label for="postcode">Irányítószám:</label>
                        <input type="text" class="form-control" name="postcode" id="postcode">
                    </div>
                    <div class="form-group">
                        <label for="city">Város:</label>
                        <input type="text" class="form-control" name="city" id="city">
                    </div>
                    <div class="form-group">
                        <label for="address">Cím:</label>
                        <input type="text" class="form-control" name="address" id="address">
                    </div>
                    <div class="form-group">
                        <label for="contact">Kapcsolattartó:</label>
                        <input type="text" class="form-control" name="contact" id="contact">
                    </div>
                    <div class="form-group">
                        <label for="nav_technical_username">Nav technikai felhasználónév:</label>
                        <input type="text" class="form-control" name="nav_technical_username" id="nav_technical_username">
                    </div>
                    <div class="form-group">
                        <label for="nav_technical_password">Nav technikai jelszó:</label>
                        <input type="text" class="form-control" name="nav_technical_password" id="nav_technical_password">
                    </div>
                    <div class="form-group">
                        <label for="nav_technical_cart">Nav technikai aláírás:</label>
                        <input type="text" class="form-control" name="nav_technical_signkey" id="nav_technical_signkey">
                    </div>
                    <div class="form-group">
                        <label for="nav_technical_cart">Nav technikai kulcs:</label>
                        <input type="text" class="form-control" name="nav_technical_exchangekey" id="nav_technical_exchangekey">
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitCreateCompanyForm">Mentés</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->
    <div class="modal" id="EditCompanyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cég szerkesztése</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="EditCompanyModalBody">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Siker!</strong>Cég frissítve.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditCompanyForm">Mentés</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete  Modal -->
    <div class="modal" id="DeleteCompanyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cég törlése</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4>Biztos, hogy törölni szeretnéd a céget?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitDeleteCompanyForm">Igen</button>
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
                ajax: '{{ route('get-company') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'vat', name: 'vat'},
                    {data: 'postcode', name: 'postcode'},
                    {data: 'city', name: 'city'},
                    {data: 'address', name: 'address'},
                    {data: 'contact', name: 'contact'},
                    {data: 'nav_technical_username', name: 'nav_technical_username'},
                    {data: 'nav_technical_password', name: 'nav_technical_password'},
                    {data: 'nav_technical_signkey', name: 'nav_technical_signkey'},
                    {data: 'nav_technical_exchangekey', name: 'nav_technical_exchangekey'},

                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ],
            });

            // Create article Ajax request.
            $('#SubmitCreateCompanyForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('company.store') }}",
                    method: 'post',
                    data: {
                        name: $('#name').val(),
                        vat: $('#vat').val(),
                        postcode: $('#postcode').val(),
                        city: $('#city').val(),
                        address: $('#address').val(),
                        contact: $('#contact').val(),
                        nav_technical_username: $('#nav_technical_username').val(),
                        nav_technical_password: $('#nav_technical_password').val(),
                        nav_technical_signkey: $('#nav_technical_signkey').val(),
                        nav_technical_exchangekey: $('#nav_technical_exchangekey').val(),

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
                                $('#CreateCompanyModal').modal('hide');
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            });

            // Update  Ajax request.
            $('#SubmitEditCompanyForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "company/"+id,
                    method: 'PUT',
                    data: {
                        name: $('#editName').val(),
                        vat: $('#editVat').val(),
                        postcode: $('#editPostcode').val(),
                        city: $('#editCity').val(),
                        address: $('#editAddress').val(),
                        contact: $('#editContact').val(),
                        nav_technical_username: $('#editNav_technical_username').val(),
                        nav_technical_password: $('#editNav_technical_password').val(),
                        nav_technical_signkey: $('#editNav_technical_signkey').val(),
                        nav_technical_exchangekey: $('#editNav_technical_exchangekey').val(),
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
                                $('#EditCompanyModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

            // Get single article in EditModel
            $('.modelClose').on('click', function(){
                $('#EditCompanyModal').hide();
            });
            var id;
            $('body').on('click', '#getEditCompanyData', function(e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "company/"+id+"/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        console.log(result);
                        $('#EditCompanyModalBody').html(result.html);
                        $('#EditCompanyModal').show();
                    }
                });
            });


            // Delete  request.
            var deleteID;
            $('body').on('click', '#getDeleteId', function(){
                deleteID = $(this).data('id');
            })
            $('#SubmitDeleteCompanyForm').click(function(e) {
                e.preventDefault();
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "company/"+id,
                    method: 'DELETE',
                    success: function(result) {
                        setInterval(function(){
                            location.reload();
                            $('#DeleteCompanyModal').hide();
                        }, 1000);
                    }
                });
            });

        });
    </script>
@endsection
