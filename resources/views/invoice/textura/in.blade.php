@extends('layouts.app')

@section('content')

    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Bejövő számlák
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable" id="textura-table">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle" width="40">Id</th>
                                <th class="align-middle">Számlaszám</th>
                                <th class="align-middle">Nettó</th>
                                <th class="align-middle">Áfa</th>
                                <th class="align-middle">Bruttó</th>
                                <th class="align-middle">Számla kelt.</th>
                                <th width="25" class="align-middle"></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="InvoiceModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Számla tételei</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="InvoiceModalBody">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {

            // init datatable.
            const dataTable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 50,
                // scrollX: true,
                "order": [[ 0, "desc" ]],
                ajax: '{{ route('get-textura') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'serial_number', name: 'serial_number'},
                    {data: 'netto', name: 'netto'},
                    {data: 'vat', name: 'vat'},
                    {data: 'brutto', name: 'brutto'},
                    {data: 'date', name: 'date'},
                    {data: 'Action', name: 'Action'},
                ],
            });

        });
    </script>
@endsection
