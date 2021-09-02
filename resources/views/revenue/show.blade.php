@extends('layouts.app')

@section('content')


    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="col-md-12">


            {{-- Számla adatai --}}
            <div class="card ">
                <div class="card-header" style="font-size: 15px;">
                    Számla adatai: {{$revenue->nav_invoice_in->invoiceNumber}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h6>Eladó: {{$revenue->nav_invoice_in->supplierName}}</h6>
                        </div>
                        <div class="col-6">
                            <h6>Vevő: {{$revenue->nav_invoice_in->company->name}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Számla adatai vége --}}

            {{-- Számla tételei --}}
            <div class="card mt-4">
                <div class="card-header" style="font-size: 15px;">
                    Számla tételei
                    <button type="button" id="revenueSubmit" class="btn btn-success pull-left" style="float: right; margin-right: 1%">Bevételezés</button>
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
                                <th class="align-middle">Státusz</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #ece6e6">
                                    <td>Összesen: </td>
                                    <td> - </td>
                                    <td>{{ $revenue->allQty }}</td>

                                    <td>{{ number_format($revenue->nav_invoice_in->invoiceNetAmountHUF, 2, ',', '.') }}
                                        {{ $revenue->nav_invoice_in->currency }}
                                    </td>
                                    <td>{{  number_format($revenue->nav_invoice_in->invoiceVatAmount, 2, ',', '.') }}
                                        {{ $revenue->nav_invoice_in->currency }}
                                    </td>
                                    <td>{{  number_format($revenue->nav_invoice_in->invoiceNetAmountHUF + $revenue->nav_invoice_in->invoiceVatAmount, 2, ',', '.') }}
                                        {{ $revenue->nav_invoice_in->currency }}
                                    </td>
                                    <td>{{ $revenue->status->name }}</td>
                                </tr>
                            @foreach($revenue->revenue_items as $item)
                                @php $nav = $item->nav_invoice_in_item @endphp
                                <tr>
                                    <td>{{ $nav->lineDescription ??''}}</td>
                                    <td>{{ number_format($nav->unitPrice, 2, ',', '.') }} {{ $revenue->nav_invoice_in->currency }}</td>
                                    <td>{{ $nav->quantity }}</td>
                                    <td>{{ number_format($nav->lineNetAmountHUF, 2, ',', '.') }} {{ $revenue->nav_invoice_in->currency }}</td>
                                    <td>{{ number_format($nav->lineNetAmountHUF * $nav->vatPercentage, 2, ',', '.') }}
                                        {{ $revenue->nav_invoice_in->currency }} ({{ $nav->vatPercentage }} %)</td>
                                    <td>{{ number_format($nav->lineNetAmountHUF * $nav->vatPercentage + $nav->lineNetAmountHUF, 2, ',', '.') }}
                                        {{ $revenue->nav_invoice_in->currency }}</td>
                                    <td>@if($item->status_id == 1)
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}" name="item" id="item">
                                        @endif
                                        {{ $item->status->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Számla tételei vége --}}

            {{-- Bevételezett tételek --}}
            <div class="card mt-4">
                <div class="card-header" style="font-size: 15px;">
                    Párosított tételek
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle">Termék</th>
                                <th class="align-middle">Mennyiség</th>
                                <th class="align-middle">Nettó</th>
                                <th class="align-middle">Áfa</th>
                                <th class="align-middle">Összesen</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($revenue->revenue_items as $item)
                                @if(isset($item->revenue_textura_item))
                                    @php $textura = $item->revenue_textura_item @endphp
                                    <tr>
                                        <td>{{ $textura->raw_material->name ??''}}</td>
                                        <td>{{ $textura->quantity ??''}}</td>
                                        <td>{{ number_format($textura->netto, 2, ',', '.') }}
                                            {{ $revenue->nav_invoice_in->currency }}</td>
                                        @if($textura->vat != 0)
                                            <td>{{ number_format($textura->netto * $textura->vat / 100, 2, ',', '.') }}
                                                {{ $revenue->nav_invoice_in->currency }} ({{ $textura->vat }}%) </td>
                                            <td>{{ number_format(($textura->netto * $textura->vat / 100) + $textura->netto,
                                                   2, ',', '.') }} {{ $revenue->nav_invoice_in->currency }}</td>
                                        @else
                                            <td>{{ number_format($textura->netto * $textura->vat, 2, ',', '.') }}
                                                {{ $revenue->nav_invoice_in->currency }} </td>
                                            <td>{{ number_format($textura->netto, 2, ',', '.') }}
                                                {{ $revenue->nav_invoice_in->currency }}</td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Bevételezett tételek vége --}}


            {{-- Bevételezett tételek --}}
            <div class="card mt-4">
                <div class="card-header" style="font-size: 15px;">
                    Bevételezett tételek
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable">
                            <thead style="font-size: 16px">
                            <tr style="font-size: 18px">
                                <th class="align-middle">Termék</th>
                                <th class="align-middle">Mennyiség</th>
                                <th class="align-middle">Nettó</th>
                                <th class="align-middle">Áfa</th>
                                <th class="align-middle">Összesen</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($revenue->revenue_textura->revenue_textura_items as $textura)
                                    <tr>
                                        <td>{{ $textura->raw_material->name ??''}}</td>
                                        <td>{{ $textura->quantity ??''}}</td>
                                        <td>{{ number_format($textura->netto, 2, ',', '.') }}
                                            {{ $revenue->nav_invoice_in->currency }}</td>
                                        @if($textura->vat != 0)
                                            <td>{{ number_format($textura->netto * $textura->vat / 100, 2, ',', '.') }}
                                                {{ $revenue->nav_invoice_in->currency }} ({{ $textura->vat }}%) </td>
                                            <td>{{ number_format(($textura->netto * $textura->vat / 100) + $textura->netto,
                                                   2, ',', '.') }} {{ $revenue->nav_invoice_in->currency }}</td>
                                        @else
                                            <td>{{ number_format($textura->netto * $textura->vat, 2, ',', '.') }}
                                                {{ $revenue->nav_invoice_in->currency }} </td>
                                            <td>{{ number_format($textura->netto, 2, ',', '.') }}
                                                {{ $revenue->nav_invoice_in->currency }}</td>
                                        @endif
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Bevételezett tételek vége --}}


        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            const items = [];

            $('.form-check-input').change(function() {
                if(this.checked) {
                    items.push($(this).val());
                    $(this).prop("checked");
                } else {
                    items.pop($(this).val());
                }
            });

            $('#revenueSubmit').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url:"{{ route('revenue.inStock', $revenue->id) }}",
                   // url: "revenue/"+id+"in",
                    method: 'PUT',
                    data: {
                        data: items,
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
                                $('#EditUserModal').hide();
                            }, 2000);
                        }
                    }
                });
            });

        });
    </script>
@endsection
