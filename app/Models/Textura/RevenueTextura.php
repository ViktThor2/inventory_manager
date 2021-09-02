<?php

namespace App\Models\Textura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RevenueTextura extends Model
{
    use HasFactory;

    protected $table = 'textura_bevetelezesek';
    protected $guarded = array();

    public function scopeHasNoPair($query)
    {
        $query->where('has_pair', 0);
    }


    public function scopePaginateDB($query)
    {
        $query->whereBetween('id', [90000,99206]);
    }

    public function scopeLastMount($query)
    {
        $query->where('created_at','>', date('Y-m-d', strtotime('-30 day')) );
    }

    public function scopeRevenueContain($query, $number)
    {
        $query->where('serial_number', 'LIKE', "%{$number}%");
    }

    public function scopeIssueDate($query, $date)
    {
        $query->where('date', $date);
    }

    public function searchInvoices($invoices, $number)
    {
        foreach ($invoices as $invoice):
            for($x=0; $x<9; $x++):
                $invNumber = Str::substr($number, $x);
                if($invNumber == $invoice->serial_number):
                    return $invoice;
                endif;
            endfor;
        endforeach;
    }

    public function setMoney()
    {
        foreach ($this->revenue_textura_items as $item):
            $this->netto += $item->netto;
            $this->vat += $item->netto * ($item->vat / 100);
            $this->quantity += $item->quantity;
        endforeach;
        $this->brutto = $this->netto + $this->vat;
    }

    public function hasItems($item)
    {
        foreach ($this->revenue_textura_items as $textura_item):
            if( $item->AlapanyagID == $textura_item->raw_material_id
                && $item->BevetelezesID == $textura_item->revenue_textura_id ):
                return true;
            endif;
        endforeach;
        return false;
    }

    public function setRevenueItems()
    {
        $items = DB::connection('textura')
            ->select("select * from dbo.BevetelezesTetelek WHERE BevetelezesID = $this->id");

        foreach ($items as $item):
            // Megvizsgája létezik -e
            $texturaItem = RevenueTexturaItem::HasItem($item)->first();

            if( !isset($texturaItem) ):
                $texturaItem = new RevenueTexturaItem();
            endif;
            $texturaItem->setData($item);
            $texturaItem->save();
        endforeach;
    }
/*
    public function wrongCharacter()
    {
        $x = 0;
        while (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $this->serial_number))
        {
            $piece = Str::substr($this->serial_number, $x,5);
                strpos($this->serial_number, '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/'));
dd(strpos($this->serial_number, ));
            $x = strpos($this->serial_number, '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/') + 1;
            $this->serial_number = Str::substr($this->serial_number, $x);
            $textInvNumbers[] = $piece;
            dd($this->serial_number);
            if(strpos($this->serial_number, '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/') == false):
                return $textInvNumbers[] = $this->serial_number;
            endif;
        }
    }
*/
    public function wrongCharacter()
    {
        $wrongCharacters = ['/', '-'];
        $x = 0;
        while(strlen($this->serial_number) > 0):

            foreach ($wrongCharacters as $wrongCharacter):
                $piece = Str::substr($this->serial_number, $x,
                    strpos($this->serial_number, $wrongCharacter));
                    $x = strpos($this->serial_number, $wrongCharacter) + 1;
                $this->serial_number = Str::substr($this->serial_number, $x);
                $textInvNumbers[] = $piece;
dd($textInvNumbers);
                if(strpos($this->serial_number, $wrongCharacter) == false):
                    return $textInvNumbers[] = $this->serial_number;
                endif;

            endforeach;
        endwhile;
    }
/*
    public function wrongCharacter()
    {
        $textInvNumber = $this->serial_number;
        $textInvNumbers = [];
        $wrongCharacters = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';
        foreach ($wrongCharacters as $wrongCharacter):
            if(strpos($textInvNumber, $wrongCharacter) != false):
                $x = 0;
                while(strpos($textInvNumber, $wrongCharacter) != false) {
                    $piece = Str::substr($textInvNumber, $x, strpos($textInvNumber, $wrongCharacter));
                    $x = strpos($textInvNumber, $wrongCharacter) + 1;
                    $textInvNumber = Str::substr($textInvNumber, $x);
                    $textInvNumbers[] = $piece;
                }
            endif;
        endforeach;

        return $textInvNumbers;
    }
*/
    public function pregMatch()
    {
        $pregMatches = [
            '/[0-9]{10}/', '/[0-9]{9}/', '/[0-9]{8}/', '/[0-9]{7}/', '/[0-9]{6}/',
            '/[0-9]{5}/', '/[0-9]{4}/', '/[0-9]{3}/', '/[0-9]{2}/',
        ];
        $output_arrays = [];
        foreach($pregMatches as $pregMatch):
            preg_match($pregMatch, $this->serial_number, $output_array);

            if(is_array($output_array) && isset($output_array[0])):
                if(count($output_arrays) == 0):
                    $output_arrays[] = $output_array[0];
                else:
                    if(strpos($output_arrays[0], $output_array[0]) != false):
                        $output_arrays[] = $output_array[0];
                    endif;
                endif;
            endif;
        endforeach;
        return $output_arrays;
    }

    public function nearNavInvoice($navInvoices)
    {
        $invoice = $navInvoices[0];
        $invoice->diff = strtotime($navInvoices[0]->invoiceIssueDate) - strtotime($this->date);

        foreach ($navInvoices as $key => $navInvoice):
            $diff = strtotime($navInvoice->invoiceIssueDate) - strtotime($this->date);

            if($diff < $invoice->diff):
                $invoice = $navInvoice;
                $invoice->diff = $diff;
            endif;
        endforeach;

        return $invoice;
    }

    public function revenue_textura_items()
    {
        return $this->hasMany(RevenueTexturaItem::class);
    }

    public function importer()
    {
        return $this->belongsTo(Importer::class);
    }

    public function version()
    {
        $item = DB::connection('textura')
            ->select("select * from dbo.Bevetelezesek WHERE BevetelezesID = $this->id");
        $this->setData($item[0]);
        $this->update();
    }

    public function newRevenue()
    {
        return DB::connection('textura')
            ->select("select * from dbo.Bevetelezesek WHERE BevetelezesID > $this->id");
    }

    public function checkDiff($myCount): bool
    {
        $textCount = $this->connectedDiff();
        $text = $textCount[0];
dd($text->ukuran);
        if($myCount != $text){ return true; }
        return false;
    }

    public function connectedDiff()
    {
        return DB::connection('textura')
            ->select("select COUNT(BevetelezesID) from dbo.Bevetelezesek");
    }

    public function getDifferences($myIDs)
    {
        $textIDs = DB::connection('textura')
            ->select("select id from dbo.Bevetelezesek");

        $differenceArray1 = array_diff($myIDs, $textIDs);
        $differenceArray2 = array_diff($textIDs, $myIDs);

        return array_merge($differenceArray1, $differenceArray2);
    }

    public function setData($data)
    {
        $this->id = $data->BevetelezesID;
        $this->importer_id = $data->BeszallitoID;
        $this->serial_number = $data->Sorszam;
        $this->date = $data->Datum;
        $this->fixed_date = $data->Rogzitve;
        $this->has_pair = 0;
    }

}
