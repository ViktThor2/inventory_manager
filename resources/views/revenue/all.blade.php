@extends('layouts.app')

@section('content')

    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Bevételezés
                    <a href="{{ route('revenue') }}" class="btn btn-primary" >Párosított</a>
                    <a href="{{ route('revenue.all') }}" class="btn btn-primary" >Összes</a>
                    <a href="{{ route('revenue.invoice') }}" class="btn btn-primary" style="float: right">Párosítás</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle">Státusz</th>
                                <th class="align-middle">Számlaszám</th>
                                <th class="align-middle">Cég</th>
                                <th class="align-middle">Partner</th>
                                <th class="align-middle">Nettó</th>
                                <th class="align-middle">Bruttó</th>
                                <th class="align-middle">Kiállítás</th>
                                <th class="align-middle">Teljesítés</th>
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
            let dataTable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 50,
                // scrollX: true,
                "order": [[ 0, "desc" ]],
                ajax: '{{ route('revenue.all') }}',
                columns: [
                    {data: 'status', name: 'status'},
                    {data: 'invoiceNumber', name: 'invoiceNumber'},
                    {data: 'customerName', name: 'customerName'},
                    {data: 'supplierName', name: 'supplierName'},
                    {data: 'invoiceNetAmount', name: 'invoiceNetAmount'},
                    {data: 'brutto', name: 'brutto'},
                    {data: 'invoiceIssueDate', name: 'invoiceIssueDate'},
                    {data: 'paymentDate', name: 'paymentDate'},
                    {data: 'Actions', name: 'Actions'}
                ],

            });

        });
    </script>
@endsection
