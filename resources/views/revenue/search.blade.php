<form method="post" action="{{ route('revenue.invoice') }}">
    @csrf
    <div class="row">

        <div class="col-4">
            <!-- Keresés cégek között -->
            <select class="form-control select2 mb-2" name="company" id="company" >
                <option value=""  selected>Kérem válasszon céget</option>
                @foreach ($companies as $key => $val)
                    @if ($search['company'] == $val->id)
                        <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                    @else
                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                    @endif
                @endforeach
            </select>
            <!-- Keresés cégek között vége-->

            <!-- Keresés partnerek között -->
            <select class="form-control select2 mb-2" name="partner" id="company" >
                <option value=""  selected>Kérem válasszon partnert</option>
                @foreach ($partners as $key => $val)
                    @if ($search['partner'] == $val->supplierTaxNumber)
                        <option value="{{ $val->supplierTaxNumber }}" selected>{{ $val->supplierName }}</option>
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
                       placeholder="Minimum ár" value="{{ $search['PriceMin'] }}">
            </div>

            <div class="input-group mb-2">
                <input type="text" class="form-control" name="PriceMax"
                       placeholder="Maxaimum ár" value="{{ $search['PriceMax'] }}">
            </div>
        </div>

        <div class="col-3">
            <div class="input-group mb-2">
                <input type="date" class="form-control" name="fromDate"
                       id="fromDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $search['fromDate'] }}">
            </div>
            <div class="input-group mb-2">
                <input type="date" class="form-control" name="toDate"
                       id="toDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $search['toDate'] }}">
            </div>
        </div>

        <div class="col-2">
                <button type="submit" class="btn btn-primary" style="float: right;">Keresés</button>
        </div>

    </div>
</form>
