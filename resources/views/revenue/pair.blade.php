@extends('layouts.app')

@section('content')

    {{-- Index --}}
    <div class="row justify-content-center">
        <div class="row">

            <div class="col-7" style="padding: 5px">
                <div class="card" style="margin: 5px">
                    <div class="card-header" style="font-size: 15px;">
                        Számlák
                    </div>
                    <div class="card-body">

                        @include('revenue.search')

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover datatable">
                                <thead style="font-size: 16px">
                                <tr style="font-size: 18px">
                                    <th class="align-middle">Számlaszám</th>
                                    <th class="align-middle">Cég</th>
                                    <th class="align-middle">Partner</th>
                                    <th class="align-middle">Nettó</th>
                                    <th width="100px" class="align-middle">Kiállítás</th>
                                    <th width="50px"><input type="submit" class="btn btn-primary w-100" value="Párosítás"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($revenues as $revenue)
                                    <tr>
                                        <td>{{ $revenue->invoiceNumber }}</td>
                                        <td>{{ $revenue->customerName }}</td>
                                        <td>{{ $revenue->supplierName }}</td>
                                        <td>{{ $revenue->invoiceNetAmount }}</td>
                                        <td>{{ $revenue->invoiceIssueDate }}</td>
                                        <td><input type="number" name="textura" placeholder="Bevételezés ID"></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-5" style="padding: 5px">
                <div class="card" style="margin: 5px">
                    <div class="card-header" style="font-size: 15px;">
                        Bevételezések
                    </div>
                    <div class="card-body">

                     {{--   @include('revenue.revenueSearch')
--}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover datatable" id="textura-table">
                                <thead style="font-size: 16px">
                                <tr style="font-size: 18px">
                                    <th class="align-middle" width="40">ID</th>
                                    <th class="align-middle">Számlaszám</th>
                                    <th class="align-middle">Beszálító</th>
                                    <th class="align-middle">Kiállítás</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($texturas as $textura)
                                    <tr>
                                        <td>{{ $textura->id }}</td>
                                        <td>{{ $textura->serial_number }}</td>
                                        <td>{{ $textura->importer->name ??''}}</td>
                                        <td>{{ $textura->date }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
