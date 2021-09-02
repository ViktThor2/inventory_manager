<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';
    protected $guarded = array();

    public function scopeTax($query,$tax)
    {
        $query->where('supplierTaxNumber', $tax);
    }

    public function scopeTexturaImporter($query, $importer)
    {
        $query->where('supplierName', 'LIKE', "%{$importer->name}%")
            ->orWhere('postalCode', $importer->postalCode)
            ->where('additionalAddressDetail', 'LIKE', "%$importer->street%");
    }


    public function setData($data)
    {
        $this->supplierTaxNumber = $data['supplierTaxNumber'];
        $this->supplierName = $data['supplierName'];
    }

    public function setItem($data)
    {
        $this->supplierBankAccountNumber = (isset($data->supplierBankAccountNumber) ? $data->supplierBankAccountNumber : null);
        $this->countyCode = (isset($data->supplierTaxNumber->countyCode) ? $data->supplierTaxNumber->countyCode : null);

        if( isset($data->supplierTaxNumber->vatCode) or isset($data->communityVatNumber) ) {
            $this->vatCode = (isset($data->supplierTaxNumber->vatCode) ? $data->supplierTaxNumber->vatCode : $data->communityVatNumber);
        }

        if ( isset($data->supplierAddress->simpleAddress) ) {
            $this->countryCode = $data->supplierAddress->simpleAddress->countryCode;
            $this->postalCode = $data->supplierAddress->simpleAddress->postalCode;
            $this->city = $data->supplierAddress->simpleAddress->city;
            $this->additionalAddressDetail = $data->supplierAddress->simpleAddress->additionalAddressDetail;
        }

        if( isset($data->supplierAddress->detailedAddress) ) {
            $this->countryCode = $data->supplierAddress->detailedAddress->countryCode;
            $this->postalCode = $data->supplierAddress->detailedAddress->postalCode;
            $this->city = $data->supplierAddress->detailedAddress->city;
            $this->additionalAddressDetail = $this->setDetailedAddress($data->supplierAddress->detailedAddress);
        }

    }

    public function setDetailedAddress($address)
    {
        return  $address->streetName .' '. $address->publicPlaceCategory .' '. $address->number;
    }

    public function getSupplier($data)
    {
        $supplier = json_encode($data->invoiceMain->invoice->invoiceHead->supplierInfo);
        return json_decode($supplier);
    }

    public function getTax($supplier)
    {

        if (isset($supplier->supplierTaxNumber->taxpayerId)) {
            $this->tax = $supplier->supplierTaxNumber->taxpayerId;
        }
        if (isset($supplier->communityVatNumber)) {
            $this->tax = Str::substr($supplier->communityVatNumber, 2);
        }
    }

    public function hasTax()
    {
        return static::Tax($this->tax);
    }


}
