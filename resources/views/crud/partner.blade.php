@extends('layouts.app')

@section('content')


    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Partnerek
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-condensed table-bordered table-hover datatable" id="partners-table">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle"></th>
                                <th class="align-middle">Id</th>
                                <th class="align-middle">Név</th>
                                <th class="align-middle">Város</th>
                                <th class="align-middle">Cím</th>
                                <th class="align-middle">Kapcsolattartó</th>
                                <th class="align-middle">Telefonszám</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->
    <div class="modal" id="EditPartnerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Kapcsolattartó szerkesztése</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="EditPartnerModalBody">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Siker!</strong>Partner frissítve.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditPartnerForm">Mentés</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script id="details-template" type="text/x-handlebars-template">
        <table class="table">
            <tr>
                <td width="25%">Név:</td>
                <td>@{{  supplierName }}</td>
            </tr>
            <tr>
                <td>Város:</td>
                <td>@{{ postalCode }}, @{{ city }}</td>
            </tr>
            <tr>
                <td>Cím:</td>
                <td>@{{ additionalAddressDetail }}</td>
            </tr>
            <tr>
                <td>Bankszámlaszám:</td>
                <td>@{{ supplierBankAccountNumber }}</td>
            </tr>
            <tr>
                <td>Adószám:</td>
                <td>@{{ supplierTaxNumber }} - @{{ vatCode }} - @{{ countyCode }}</td>
            </tr>
            <tr>
                <td>Kapcsolattartó:</td>
                <td>@{{ contactName }}</td>
            </tr>
            <tr>
                <td>Kapcsolattartó telefonszáma:</td>
                <td>@{{ contactPhone }}</td>
            </tr>
        </table>
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            const template = Handlebars.compile($("#details-template").html());

            // init datatable.
            const dataTable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 50,
                // scrollX: true,
                ajax: '{{ route('get-partner') }}',
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":     false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {data: 'id', name: 'id'},
                    {data: 'supplierName', name: 'supplierName'},
                    {data: 'city', name: 'city'},
                    {data: 'additionalAddressDetail', name: 'additionalAddressDetail'},
                    {data: 'contactName', name: 'contactName'},
                    {data: 'contactPhone', name: 'contactPhone  '},
                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ],
                order: [[1, 'asc']]
            });

            // Add event listener for opening and closing details
            $('#partners-table tbody').on('click', 'td.details-control', function () {
                const tr = $(this).closest('tr');
                const row = dataTable.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });

            // Update  Ajax request.
            $('#SubmitEditPartnerForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "partner/"+id,
                    method: 'PUT',
                    data: {
                        contactName: $('#editContactName').val(),
                        contactPhone: $('#editContactPhone').val(),
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
                                $('#EditPartnerModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

            // Get single article in EditModel
            $('.modelClose').on('click', function(){
                $('#EditPartnerModal').hide();
            });
            var id;
            $('body').on('click', '#getEditPartnerData', function(e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "partner/"+id+"/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        console.log(result);
                        $('#EditPartnerModalBody').html(result.html);
                        $('#EditPartnerModal').show();
                    }
                });
            });

        });
    </script>
@endsection
