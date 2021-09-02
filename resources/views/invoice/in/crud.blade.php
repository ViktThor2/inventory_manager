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
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle" width="40">Id</th>
                                <th class="align-middle">Cég</th>
                                <th class="align-middle">Számlaszám</th>
                                <th class="align-middle">Számla kelt.</th>
                                <th class="align-middle">Beszállító</th>
                                <th class="align-middle">Fizetési módok</th>
                                <th class="align-middle">Fizetési határidó</th>
                                <th class="align-middle">Nettó összeg</th>
                                <th class="align-middle">Áfa összege</th>
                                <th class="align-middle">Végösszeg</th>
                                <th class="align-middle">Valuta</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
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
                ajax: '{{ route('get-invoice') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'customerName', name: 'customerName'},
                    {data: 'invoiceNumber', name: 'invoiceNumber'},
                    {data: 'invoiceIssueDate', name: 'invoiceIssueDate'},
                    {data: 'supplierName', name: 'supplierName'},
                    {data: 'paymentMethod', name: 'paymentMethod'},
                    {data: 'paymentDate', name: 'paymentDate'},
                    {data: 'invoiceNetAmount', name: 'invoiceNetAmount'},
                    {data: 'invoiceVatAmount', name: 'invoiceVatAmount'},
                    {data: 'brutto', name: 'brutto'},
                    {data: 'currency', name: 'currency'},
                    {data: 'Actions', name: 'Actions'}
                ],
            });


            // Get single article in EditModel
            $('.modelClose').on('click', function(){
                $('#ShowInvoiceModal').hide();
            });
            var id;
            $('body').on('click', '#getShowInvoiceData', function(e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "invoice/"+id,
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        console.log(result);
                        $('#ShowInvoiceModalBody').html(result.html);
                        $('#ShowInvoiceModal').show();
                    }
                });
            });
        });
    </script>
@endsection
