<form method="post" action="{{ route('revenue.revenue.search') }}">
    @csrf
    <div class="row">

        <div class="col-4">

            <!-- Keresés partnerek között -->
            <select class="form-control select2 mb-2" name="importer" id="company" >
                <option value=""  selected>Kérem válasszon beszállítót</option>
                @foreach ($importer as $key => $val)
                    @if ($searchRevenue['importer'] == $val->supplierTaxNumber)
                        <option value="{{ $val->supplierTaxNumber }}" selected>{{ $val->name }}</option>
                    @else
                        <option value="{{ $val->supplierTaxNumber }}">{{ $val->supplierName }}</option>
                    @endif
                @endforeach
            </select>
            <!-- Keresés partnerek között vége-->
        </div>

        <div class="col-3">
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="PriceMin"
                       placeholder="Minimum ár" value="{{ $searchRevenue['PriceMin'] }}">
            </div>

            <div class="input-group mb-2">
                <input type="text" class="form-control" name="PriceMax"
                       placeholder="Maxaimum ár" value="{{ $searchRevenue['PriceMax'] }}">
            </div>
        </div>

        <div class="col-3">
            <div class="input-group mb-2">
                <input type="date" class="form-control" name="fromDate"
                       id="fromDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $searchRevenue['fromDate'] }}">
            </div>
            <div class="input-group mb-2">
                <input type="date" class="form-control" name="toDate"
                       id="toDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $searchRevenue['toDate'] }}">
            </div>
        </div>

        <div class="col-2">
            <button type="submit" class="btn btn-primary" style="float: right;">Keresés</button>
        </div>

    </div>
</form>
