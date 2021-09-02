
<!-- Collapsable Card Example -->
<div class="card shadow mt-2">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Kereső</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">

            <form method="post" action="{{ route('invoicing') }}">
                @csrf
                <div class="row">

                    <div class="col-2">
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

                    <div class="col-2">
                        <!-- Keresés fizetési között -->
                        <select class="form-control select2 mb-2" name="payment" id="payment" >
                            <option value=""  selected>Kérem válasszon fizetési módot</option>
                            @if ($search['payment'] == "TRANSFER")
                                <option value="TRANSFER" selected>Utalás</option>
                                <option value="CASH">Készpénz</option>
                                <option value="CARD">Kártyás</option>
                                <option value="OTHER">Egyéb</option>
                            @elseif($search['payment'] == "CASH")
                                <option value="TRANSFER">Utalás</option>
                                <option value="CASH" selected>Készpénz</option>
                                <option value="CARD">Kártyás</option>
                                <option value="OTHER">Egyéb</option>
                            @elseif($search['payment'] == "CARD")
                                <option value="TRANSFER">Utalás</option>
                                <option value="CASH">Készpénz</option>
                                <option value="CARD" selected>Kártyás</option>
                                <option value="OTHER">Egyéb</option>
                            @elseif($search['payment'] == "OTHER")
                                <option value="TRANSFER">Utalás</option>
                                <option value="CASH">Készpénz</option>
                                <option value="CARD">Kártyás</option>
                                <option value="OTHER" selected>Egyéb</option>
                            @else
                                <option value="TRANSFER">Utalás</option>
                                <option value="CASH">Készpénz</option>
                                <option value="CARD">Kártyás</option>
                                <option value="OTHER">Egyéb</option>
                            @endif
                        </select>
                        <!-- Keresés fizetési között vége-->

                        <!-- Keresés státusz között -->
                        <select class="form-control select2 mb-2" name="status" id="status" >
                            <option value=""  selected>Kérem válasszon státuszt</option>
                            @foreach ($statuses as $key => $val)
                                @if ($search['status'] == $val->id)
                                    <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                                @else
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <!-- Keresés státusz között vége-->
                    </div>

                    <div class="col-2">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon1">Minimum ár : </span>
                            <input type="text" class="form-control" name="PriceMin"
                                   value="{{ $search['PriceMin'] }}">
                        </div>

                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon1">Maxaimum ár:</span>
                            <input type="text" class="form-control" name="PriceMax"
                                   value="{{ $search['PriceMax'] }}">
                        </div>
                    </div>


                    <div class="col-4">
                        <!-- Keresés számlaszámok között -->
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="invoiceNumber"
                                   placeholder="Számlaszám" value="{{ $search['invoiceNumber'] }}">
                        </div>
                        <!-- Keresés számlaszámok között vége-->

                        <div class="row">
                            <div class="col-5">
                                <div class="input-group mb-2">
                                    <input type="date" class="form-control" name="fromDate"
                                           id="fromDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $search['fromDate'] }}">
                                </div>
                            </div>
                            <i class="fas fa-minus" style="margin-top: 10px"></i>
                            <div class="col-5">
                                <div class="input-group mb-2">
                                    <input type="date" class="form-control" name="toDate"
                                           id="toDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $search['toDate'] }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <!-- Keresés-->
                        <input type="submit" class="btn btn-primary mt-2" style="float: right;" value="Keresés">
                        <!-- Keresés vége-->
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
