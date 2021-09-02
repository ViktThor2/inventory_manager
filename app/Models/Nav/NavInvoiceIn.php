<?php

namespace App\Models\Nav;

use App\Models\Company;
use App\Models\Revenue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NavInvoiceIn extends Model
{
    use HasFactory;

    protected $table = 'nav_invoice_in';
    protected $guarded = array();

    public function scopeSearchInvocing($query, $data)
    {
        if (isset($data['invoiceNumber']) && $data['invoiceNumber']) {
            $query->where('invoiceNumber', 'LIKE', '%' . $data['invoiceNumber'] . '%');
        }

        if (isset($data['company']) && $data['company']) {
            $query->where('company_id', $data['company']);
        }

        if (isset($data['partner']) && $data['partner']) {
            $query->where('supplierTaxNumber', $data['partner']);
        }

        if (isset($data['payment']) && $data['payment']) {
            $query->where('paymentMethod', 'LIKE', '%' . $data['payment'] . '%');
        }

        if(isset($data['PriceMin']) || isset($data['PriceMax']) ) {
            $priceMin = (isset($data['PriceMin']) ? $data['PriceMin'] : 0);
            $priceMax = (isset($data['PriceMax']) ? $data['PriceMax'] : 10000000000);
            $query->whereBetween('invoiceNetAmount', [$priceMin, $priceMax]);
        }

        if (isset($data['fromDate']) || isset($data['toDate']) ) {
            $fromDate = (isset($data['fromDate']) ? $data['fromDate'] : 2021-01-01);
            $toDate = (isset($data['toDate']) ? $data['toDate'] : date("Y-m-d") );
            $query->whereBetween('invoiceIssueDate', [$fromDate, $toDate]);
        }

        $query->orderBy('invoiceIssueDate', 'DESC');
    }

    public function scopeHaveItem($query)
    {
        $query->where('have_items', '0')->limit(50);
    }

    public function scopeLastRevenue($query)
    {
        $lastRevenue = Revenue::all()->last();
        $query->where('id', '>', $lastRevenue->nav_invoice_in_id);
    }

    public function scopeImporter($query, $date, $vat)
    {
//        $from = strtotime("-90 day", strtotime($date));
//        $from = date('Y-m-d', $from);
//->whereBetween('invoiceIssueDate', [$from, $date])
        $query->where('supplierTaxNumber', Str::substr($vat, 0, 8))
            ->orderBy('invoiceIssueDate', 'asc');
    }

    public function equalInvoiceNumer($number)
    {
        if(strpos($this->invoiceNumber, $number) != false):
            return true;
        endif;

        return false;
    }

    public function setInvocingIndex()
    {
        if($this->paymentMethod == 'TRANSFER'): $this->paymentMethod = 'Utalás'; endif;
        if($this->paymentMethod == 'CASH'): $this->paymentMethod = 'Készpénz'; endif;
        if($this->paymentMethod == 'CARD'): $this->paymentMethod = 'Kártyás'; endif;
        if($this->paymentMethod == 'OTHER'): $this->paymentMethod = 'Egyéb'; endif;

        $this->status = $this->revenue->status->name ??'';
        $this->brutto = $this->invoiceNetAmount + $this->invoiceVatAmount;
    }

    public function searchStatus($status)
    {
        if(isset($this->revenue->status_id)):
            if($this->revenue->status_id == $status):
                return true;
            endif;
        endif;
    }

    public function setQty()
    {
        foreach ($this->nav_invoice_in_items as $item){
            $this->qty += $item->quantity;
        }
    }

    public function setRevenueIndex($revenue)
    {
        $this->status = $revenue->status->name;
        $this->brutto = $this->invoiceNetAmount + $this->invoiceVatAmount;

        return $this;
    }

    public function nav_invoice_in_items(){
        return $this->hasMany(NavInvoiceInItem::class);
    }

    public function revenue(){
        return $this->hasOne(Revenue::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }


    public function setData($data)
    {
        $this->invoiceNumber = (isset($data['invoiceNumber']) ? $data['invoiceNumber'] : null);
        $this->invoiceOperation = (isset($data['invoiceOperation']) ? $data['invoiceOperation'] : null);
        $this->invoiceCategory = (isset($data['invoiceCategory']) ? $data['invoiceCategory'] : null);
        $this->invoiceIssueDate = (isset($data['invoiceIssueDate']) ? $data['invoiceIssueDate'] : null);
        $this->supplierTaxNumber = (isset($data['supplierTaxNumber']) ? $data['supplierTaxNumber'] : null);
        $this->supplierName = (isset($data['supplierName']) ? $data['supplierName'] : null);
        $this->customerTaxNumber = (isset($data['customerTaxNumber']) ? $data['customerTaxNumber'] : null);
        $this->customerName = (isset($data['customerName']) ? $data['customerName'] : null);
        $this->paymentMethod = (isset($data['paymentMethod']) ? $data['paymentMethod'] : null);
        $this->paymentDate = (isset($data['paymentDate']) ? $data['paymentDate'] : null);
        $this->invoiceAppearance = (isset($data['invoiceAppearance']) ? $data['source'] : null);
        $this->source = (isset($data['source']) ? $data['source'] : null);
        $this->invoiceDeliveryDate = (isset($data['invoiceDeliveryDate']) ? $data['invoiceDeliveryDate'] : null);
        $this->currency = (isset($data['currency']) ? $data['currency'] : null);
        $this->invoiceNetAmount = (isset($data['invoiceNetAmount']) ? $data['invoiceNetAmount'] : null);
        $this->invoiceNetAmountHUF = (isset($data['invoiceNetAmountHUF']) ? $data['invoiceNetAmount'] : null);
        $this->invoiceVatAmount = (isset($data['invoiceVatAmount']) ? $data['invoiceVatAmount'] : null);
        $this->invoiceVatAmountHUF = (isset($data['invoiceVatAmountHUF']) ? $data['invoiceVatAmountHUF'] : null);
        $this->transactionId = (isset($data['transactionId']) ? $data['transactionId'] : null );
        $this->index = (isset($data['index']) ? $data['index'] : null);
        $this->insDate = (isset($data['insDate']) ? $data['insDate'] : null);
        $this->completenessIndicator = (isset($data['completenessIndicator']) ? $data['completenessIndicator'] : null);
        $this->have_items = 0;
    }

}
