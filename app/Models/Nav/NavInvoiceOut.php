<?php

namespace App\Models\Nav;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavInvoiceOut extends Model
{
    use HasFactory;

    protected $table = 'nav_invoice_out';
    protected $guarded = array();

    public function nav_invoice_out_items()
    {
        return $this->hasMany(NavInvoiceOutItem::class);
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
        $this->invoiceAppearance = (isset($data['invoiceAppearance']) ? $data['invoiceAppearance'] : null);
        $this->source = (isset($data['source']) ? $data['source'] : null);
        $this->invoiceDeliveryDate = (isset($data['invoiceDeliveryDate']) ? $data['invoiceDeliveryDate'] : null);
        $this->currency = (isset($data['currency']) ? $data['currency'] : null);
        $this->invoiceNetAmount = (isset($data['invoiceNetAmount']) ? $data['invoiceNetAmount'] : null);
        $this->invoiceNetAmountHUF = (isset($data['invoiceNetAmountHUF']) ? $data['invoiceNetAmountHUF'] : null);
        $this->invoiceVatAmount = (isset($data['invoiceVatAmount']) ? $data['invoiceVatAmount'] : null);
        $this->invoiceVatAmountHUF = (isset($data['invoiceVatAmountHUF']) ? $data['invoiceVatAmountHUF'] : null);
        $this->transactionId = (isset($data['transactionId']) ? $data['transactionId'] : null);
        $this->index = (isset($data['index']) ? $data['index'] : null);
        $this->insDate = (isset($data['insDate']) ? $data['insDate'] : null);
        $this->have_items = 0;
    }
}
