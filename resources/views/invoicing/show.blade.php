<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perinvest</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table {
            border-radius: 15px;
        }
        table {
            text-align: center;
            vertical-align: middle;
        }
        .card {
            margin-left: 20px; margin-right: 15px; box-shadow: 0 15px 15px 0 rgba(0,0,0,0.2); transition: 0.8s;
        }
        .card:hover {
            box-shadow: 30px 30px 30px 20px rgba(0,0,0,0.2);
        }
    </style>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <div class="row">
                <div class="col-12">

                    {{-- Index --}}
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card mt-4" >
                                <div class="card-header" style="font-size: 15px;">
                                    <a href="{{ route('invoicing') }}" class="btn btn-info">Vissza</a>
                                    Számla tételei
                                    <form method="post" action="{{ route('invoicing.status', $invoice->id) }}">
                                        @csrf
                                        <input type="submit" class="btn btn-primary" style="float: right" value="Váltás">
                                        <!-- Keresés státusz között -->
                                        <select class="form-control select2 mb-2 w-25" name="status" id="status" style="float: right">
                                            <option value=""  selected></option>
                                            @foreach ($statuses as $key => $val)
                                                @if ($invoice->revenue->status_id == $val->id)
                                                    <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                                                @else
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover datatable">
                                            <thead style="font-size: 16px">
                                            <tr style="font-size: 18px">
                                                <th></th>
                                                <th class="align-middle">Termék</th>
                                                <th class="align-middle">Egységár</th>
                                                <th class="align-middle">Mennyiség</th>
                                                <th class="align-middle">Nettó</th>
                                                <th class="align-middle">Áfa</th>
                                                <th class="align-middle">Összesen</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($invoice->nav_invoice_in_items as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item->lineDescription ??''}}</td>
                                                    <td>{{ number_format($item->unitPrice, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                                    <td>{{ $item->quantity }} {{ $item->unitOfMeasure }}</td>
                                                    <td>{{ number_format($item->lineNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                                    <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage, 2, ',', '.') }} {{ $invoice->currency }} ({{ $item->vatPercentage }} %)</td>
                                                    <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage + $item->lineNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>-</td>
                                                <td>Összesen: </td>
                                                <td> - </td>
                                                <td>{{ $invoice->qty }}</td>
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

                    {{-- Bevételezett tételek --}}
                    <div class="card mt-4">
                        <div class="card-header" style="font-size: 15px;">
                            Bevételezett tételek
                        </div>
                        <div class="card-body">
                            @if($invoice->revenue->status_id == 1)
                                <div class="mt-2">
                                    <h6>Nincs bevételezve a számla</h6>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover datatable">
                                        <thead style="font-size: 16px">
                                        <tr style="font-size: 18px">
                                            <th class="align-middle"></th>
                                            <th class="align-middle">Termék</th>
                                            <th class="align-middle">Egységár</th>
                                            <th class="align-middle">Mennyiség</th>
                                            <th class="align-middle">Nettó</th>
                                            <th class="align-middle">Áfa</th>
                                            <th class="align-middle">Összesen</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->revenue->revenue_items as $key => $item)
                                            <tr>@php $item = $item->nav_invoice_in_item @endphp
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $item->lineDescription ??''}}</td>
                                                <td>{{ number_format($item->unitPrice, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->lineNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                                <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage, 2, ',', '.') }} {{ $invoice->currency }} ({{ $item->vatPercentage }} %)</td>
                                                <td>{{ number_format($item->lineNetAmountHUF * $item->vatPercentage + $item->lineNetAmountHUF, 2, ',', '.') }} {{ $invoice->currency }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- Bevételezett tételek vége --}}

                </div>
            </div>
        </div>

    </div>
    <!-- End of Content Wrapper -->
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>
</html>
