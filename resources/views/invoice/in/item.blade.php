@extends('layouts.app')

@section('content')


    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header" style="font-size: 15px;">
                    Számla tételei
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle">Termék</th>
                                <th class="align-middle">Egységár</th>
                                <th class="align-middle">Mennyiség</th>
                                <th class="align-middle">Nettó</th>
                                <th class="align-middle">Áfa</th>
                                <th class="align-middle">Összesen</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->nav_invoice_in_items as $item)
                                    <tr>
                                        <td>{{ $item->lineDescription ??''}}</td>
                                        <td>{{ number_format($item->unitPrice, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->lineNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                        <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage, 2, ',', '.') }} {{ $invoice->currency }} ({{ $item->vatPercentage }} %)</td>
                                        <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage + $item->lineNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                    </tr>
                                @endforeach
                            <tr>
                                <td>Összesen: </td>
                                <td> - </td>
                                <td>{{ $invoice->allQty }}</td>
                                <td>{{ number_format($invoice->invoiceNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                <td>{{  number_format($invoice->invoiceVatAmount, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                <td>{{  number_format($invoice->invoiceNetAmountHUF + $invoice->invoiceVatAmount, 2, ',', '.') }} {{ $invoice->currency }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


