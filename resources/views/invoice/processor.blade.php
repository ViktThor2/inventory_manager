@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">

        <div class="card mb-3">
            <div class="card-header" style="font-size: 15px;">
                Külömbözet
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
                        @foreach($differencia as $item )
                            <tr>
                                <td>{{ $item->lineDescription }}</td>
                                <td>{{ number_format($item->unitPrice, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->lineNetAmountHUF, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage, 2, ',', '.') }} {{ $navInvoice->currency }} ({{ $item->vatPercentage * 100 }} %)</td>
                                <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage + $item->lineNetAmountHUF, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



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
                            @foreach($navInvoice->nav_invoice_in_items as $item )
                                <tr>
                                    <td>{{ $item->lineDescription }}</td>
                                    <td>{{ number_format($item->unitPrice, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->lineNetAmountHUF, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                    <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage, 2, ',', '.') }} {{ $navInvoice->currency }} ({{ $item->vatPercentage * 100 }} %)</td>
                                    <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage + $item->lineNetAmountHUF, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-3" >
                <div class="card-header" style="font-size: 15px;">
                    Bevételezett tételek
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
                                @foreach($texturaInvoice->revenue_items as $item )
                                    <tr>
                                        <td>{{ $item->raw_material->name ?? ''}}</td>
                                        <td>{{ number_format($item->netto / $item->quantity, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->netto, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                        <td>{{ number_format($item->netto * ($item->vat / 100), 2, ',', '.') }} {{ $navInvoice->currency }} ({{ $item->vat }} %)</td>
                                        <td>{{ number_format($item->netto * ($item->vat /100) + $item->netto, 2, ',', '.') }} {{ $navInvoice->currency }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>


@endsection
