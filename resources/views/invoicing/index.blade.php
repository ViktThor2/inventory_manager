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
                    <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top: 5px; margin-left: 25px">Főmenü</a>

                    @include('invoicing.search')

                    @if(isset($invoices))
                        <div class="card mt-2">
                            <div class="card-header" style="font-size: 15px;">
                                Számlák
                            </div>
                            <div class="card-body">
                                <div>
                                    <button id="submitStatus" class="btn btn-primary" style="float: right">Váltás</button>
                                    <!-- Keresés státusz között -->
                                    <select class="form-control select2 mb-2 w-25" style="float: right" name="data[Revenue][status]" id="RevenueStatus">
                                        <option value=""  selected>Kérem válasszon státuszt</option>
                                        @foreach ($statuses as $key => $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover datatable">
                                        <thead style="font-size: 16px">
                                        <tr style="font-size: 18px">
                                            <th>Kijelöl</th>
                                            <th class="align-middle">Státusz</th>
                                            <th class="align-middle">Számlaszám</th>
                                            <th width="400px" class="align-middle">Cég</th>
                                            <th width="400px" class="align-middle">Partner</th>
                                            <th class="align-middle">Fizetési mód</th>
                                            <th class="align-middle">Netto</th>
                                            <th class="align-middle">Brutto</th>
                                            <th class="align-middle">Valuta</th>
                                            <th width="200px" class="align-middle">Kiállítás</th>
                                            <th class="align-middle"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr @if($invoice->revenue->status_id == 1) style="background-color: #ffa39c"
                                                @elseif($invoice->revenue->status_id == 4) style="background-color: #b0ffe1"
                                                @endif>
                                                <td><input class="form-check-input" type="checkbox" style="width: 20px; height: 20px"
                                                     value="{{ $invoice->id }}" name="invCheack" id="invCheack">
                                                </td>
                                                <td class="align-middle">{{ $invoice->status ??''}}</td>
                                                <td class="align-middle">{{ $invoice->invoiceNumber ??''}}</td>
                                                <td class="align-middle">{{ $invoice->customerName ??''}}</td>
                                                <td class="align-middle">{{ $invoice->supplierName ??''}}</td>
                                                <td class="align-middle">{{ $invoice->paymentMethod ??''}}</td>
                                                <td class="align-middle">{{ $invoice->invoiceNetAmount ??''}}</td>
                                                <td class="align-middle">{{ $invoice->brutto ??''}}</td>
                                                <td class="align-middle">{{ $invoice->currency ??''}}</td>
                                                <td class="align-middle">{{ $invoice->invoiceIssueDate ??''}}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('invoicing.show', $invoice->id) }}" class="btn btn-link btn-sm">
                                                        <i class="fas fa-edit fa-lg"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                        </div>

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

<script type="text/javascript">
    $(document).ready(function() {

        const invoices = [];

        $('.form-check-input').change(function() {
            if(this.checked) {
                invoices.push($(this).val());
                $(this).prop("checked");
            } else {
                invoices.pop($(this).val());
            }
        });

        $('#submitStatus').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{ route('invoicing.massStatus') }}",
                method: 'PUT',
                data: {
                    data: invoices,
                    status: $('#RevenueStatus option:selected').val()
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        alert(result.success);
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

</body>
</html>
