<?php

namespace App\Models\Nav;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavInvoiceOutItem extends Model
{
    use HasFactory;

    protected $table = 'nav_invoice_out_item';
    protected $guarded = array();

    public function nav_invoice_out_items()
    {
        return $this->hasMany(NavInvoiceOutItem::class);
    }

    public function setData($data, $inv)
    {
        $this->invoiceNumber = $inv->invoiceNumber;
        $this->supplierName = $inv->supplierName;
        $this->lineDescription = (isset($data['lineDescription']) ? $data['lineDescription'] : null);
        $this->quantity = (isset($data['quantity']) ? $data['quantity'] : null);
        $this->unitOfMeasure = (isset($data['unitOfMeasure']) ? $data['unitOfMeasure'] : null);
        $this->unitPrice = (isset($data['unitPrice']) ? $data['unitPrice'] : nulll);
        $this->lineNetAmount = (isset($data['lineAmountsNormal']['lineNetAmountData']['lineNetAmount']) ? $data['lineAmountsNormal']['lineNetAmountData']['lineNetAmount'] : null);
        $this->lineNetAmountHUF = (isset($data['lineAmountsNormal']['lineNetAmountData']['lineNetAmountHUF']) ? $data['lineAmountsNormal']['lineNetAmountData']['lineNetAmount'] : null);
        $this->vatPercentage = (isset($data['lineAmountsNormal']['lineVatRate']['vatPercentage']) ? $data['lineAmountsNormal']['lineVatRate']['vatPercentage'] : null);
    }
}
