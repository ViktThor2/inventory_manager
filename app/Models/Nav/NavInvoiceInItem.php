<?php

namespace App\Models\Nav;

use App\Models\RevenueItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavInvoiceInItem extends Model
{
    use HasFactory;

    protected $table = 'nav_invoice_in_items';
    protected $guarded = array();

    public function scopeRevenueItemLast($query)
    {
        $lastRevenueItem = RevenueItem::all()->last();
        $query->where('id', '>', $lastRevenueItem->nav_invoice_in_item_id)->limit(1000);
    }

    public function scopeTax($query,$tax)
    {
        $query->where('transactionId', $tax);
    }

    public function nav_invoice_in(){
        return $this->belongsTo(NavInvoiceIn::class);
    }

    public function revenue_item(){
        return $this->hasMany(RevenueItem::class);
    }

    public function setData($data, $inv)
    {
        $this->nav_invoice_in_id = $inv->id;
        $this->productCodeCategory = (isset($data['productCodes']['productCode']['productCodeCategory']) ? $data['productCodes']['productCode']['productCodeCategory'] : null);
        $this->productCodeOwnValue = (isset($data['productCodes']['productCode']['productCodeOwnValue']) ? $data['productCodes']['productCode']['productCodeOwnValue'] : null);
        $this->lineDescription = (isset($data['lineDescription']) ? $data['lineDescription'] : null);
        $this->quantity = (isset($data['quantity']) ? $data['quantity'] : null);
        $this->unitOfMeasure = (isset($data['unitOfMeasure']) ? $data['unitOfMeasure'] : null);
        $this->unitPrice = (isset($data['unitPrice']) ? $data['unitPrice'] : null);
        $this->lineNetAmount = (isset($data['lineAmountsNormal']['lineNetAmountData']['lineNetAmount']) ? $data['lineAmountsNormal']['lineNetAmountData']['lineNetAmount'] : null);
        $this->lineNetAmountHUF = (isset($data['lineAmountsNormal']['lineNetAmountData']['lineNetAmountHUF']) ? $data['lineAmountsNormal']['lineNetAmountData']['lineNetAmount'] : null);
        $this->vatPercentage = (isset($data['lineAmountsNormal']['lineVatRate']['vatPercentage']) ? $data['lineAmountsNormal']['lineVatRate']['vatPercentage'] : null);
        $this->dataName = (isset($data['additionalLineData']['dataName']) ? $data['additionalLineData']['dataName'] : null);
        $this->dataDescription = (isset($data['additionalLineData']['dataDescription']) ? $data['additionalLineData']['dataDescription'] : null);
        $this->dataValue = (isset($data['additionalLineData']['dataValue']) ? $data['additionalLineData']['dataValue'] : null);
    }

}
