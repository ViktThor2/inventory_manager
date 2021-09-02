<?php

namespace App\Models\Nav;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NavOnlineInvoice;
use Illuminate\Support\Str;

class Nav extends Model
{
    use HasFactory;

    public function token($company)
    {
        $userData = array(
            "login" => $company['nav_technical_username'],
            "password" => $company['nav_technical_password'],
            // "passwordHash" => "...",
            // Opcionális, a jelszó már SHA512 hashelt változata. Amennyiben létezik ez a változó, akkor az authentikáció során ezt használja
            "taxNumber" => substr($company['vat'], 0,8),
            "signKey" => $company['nav_technical_signkey'],
            "exchangeKey" => $company['nav_technical_exchangekey'],
        );

        $softwareData = array(
            "softwareId" => "HU6750412345678965",
            "softwareName" => "WFY Online Számlázó",
            "softwareOperation" => "ONLINE_SERVICE",
            "softwareMainVersion" => "1.0",
            "softwareDevName" => "string",
            "softwareDevContact" => "Nagy Roland",
            "softwareDevCountryCode" => "HU",
            "softwareDevTaxNumber" => "67367504",
        );

        $apiUrl = "https://api.onlineszamla.nav.gov.hu/invoiceService/v3";

        $config = new NavOnlineInvoice\Config($apiUrl, $userData, $softwareData);
        $config->setCurlTimeout(70); // 70 másodperces cURL timeout (NAV szerver hívásnál), opcionális

        $reporter = new NavOnlineInvoice\Reporter($config);
        $token = $reporter->tokenExchange();

        return $reporter;
    }

    public function invoices($reporter)
    {
        try {
            $invoiceQueryParams = [
                "mandatoryQueryParams" => [
                    "invoiceIssueDate" => [
                        "dateFrom" => date('Y-m-d', strtotime('-2 day')),
                        "dateTo" => date('Y-m-d'),
                    ],
                ],
            ];
            $page = 1;

            return $reporter->queryInvoiceDigest($invoiceQueryParams, $page, "INBOUND");
        }

        catch(Exception $ex) {
            print get_class($ex) . ": " . $ex->getMessage();
        }
    }


    public function invoiceLines($reporter, $invoice)
    {
        $invoiceChainQuery = [
            "invoiceNumber" => $invoice->invoiceNumber,
            "invoiceDirection" => "INBOUND",
            "supplierTaxNumber" => $invoice->supplierTaxNumber, // optional
        ];
        $page = 1;

        return $reporter->queryInvoiceData($invoiceChainQuery, $page);
    }


    public function invoicesOut($reporter)
    {
        try {
            $invoiceQueryParams = [
                "mandatoryQueryParams" => [
                    "invoiceIssueDate" => [
                        "dateFrom" => date('Y-m-d', strtotime('-2 day')),
                        "dateTo" => date('Y-m-d'),
                    ],
                ],
            ];
            $page = 1;

            return $reporter->queryInvoiceDigest($invoiceQueryParams, $page, "OUTBOUND");
        }

        catch(Exception $ex) {
            print get_class($ex) . ": " . $ex->getMessage();
        }
    }


    public function invoiceLinesOut($reporter, $invoice)
    {
        $invoiceNumberQuery = [
            "invoiceNumber" => $invoice->invoiceNumber,
            "invoiceDirection" => "OUTBOUND",
        ];

        return  $reporter->queryInvoiceData($invoiceNumberQuery, true);
    }


}


//eredeti
	/*
	 * public function navtest(){


	$userData = array(
		"login" => "kl15o4lw4vjmr4a",
		"password" => "NagyRoland2021",
		// "passwordHash" => "...", // Opcionális, a jelszó már SHA512 hashelt változata. Amennyiben létezik ez a változó, akkor az authentikáció során ezt használja
		"taxNumber" => "67367504",
		"signKey" => "24-b236-f18dc89f31f73EWIO0R33GP9",
		"exchangeKey" => "1b6a3EWIO0R35PF1",
	);
	$softwareData = array(
		"softwareId" => "HU6750412345678965",
		"softwareName" => "WFY Online Számlázó",
		"softwareOperation" => "ONLINE_SERVICE",
		"softwareMainVersion" => "1.0",
		"softwareDevName" => "string",
		"softwareDevContact" => "Nagy Roland",
		"softwareDevCountryCode" => "HU",
		"softwareDevTaxNumber" => "67367504",
	);

	$apiUrl = "https://api.onlineszamla.nav.gov.hu/invoiceService/v3";

	$config = new NavOnlineInvoice\Config($apiUrl, $userData, $softwareData);
	$config->setCurlTimeout(70); // 70 másodperces cURL timeout (NAV szerver hívásnál), opcionális

	//"Connection error. CURL error code: 60" hiba esetén add hozzá a következő sort:
	 $config->verifySSL = false;

	$reporter = new NavOnlineInvoice\Reporter($config);

	try {
    $token = $reporter->tokenExchange();
    print "Token: " . $token;

} catch(Exception $ex) {
    print get_class($ex) . ": " . $ex->getMessage();
}
try {
 $invoiceQueryParams = [
        "mandatoryQueryParams" => [
            "invoiceIssueDate" => [
                "dateFrom" => "2021-01-01",
                "dateTo" => "2021-01-30",
            ],
        ],

		"transactionQueryParams"=>
			['transactionId'=>'388ZRVKPCHGXG6TW']
    ];

    $page = 1;

    $invoiceDigestResult = $reporter->queryInvoiceDigest($invoiceQueryParams, $page, "INBOUND");

    print "Query results XML elem:\n";
    var_dump($invoiceDigestResult);

} catch(Exception $ex) {
    print get_class($ex) . ": " . $ex->getMessage();
}



try {
    $invoiceNumberQuery = [
        "invoiceNumber" => "F-K14081/21",
        "invoiceDirection" => "INBOUND",
    ];

    // Lekérdezés
    $invoiceDataResult = $reporter->queryInvoiceData($invoiceNumberQuery);

    print "Query results XML elem:\n";
    print_r($invoiceDataResult);

    // Számla kézi dekódolása
    //$invoice = NavOnlineInvoice\InvoiceOperations::convertToXml($invoiceDataResult->invoiceData, $invoiceDataResult->compressedContentIndicator);

    // Számla:
   // var_dump($invoice);

    // *** VAGY ***

    // Lekérdezés és számla automatikus dekódolása
    $invoice = $reporter->queryInvoiceData($invoiceNumberQuery, true); // 2. paraméter jelzi az automatikus dekódolást

    // Számla:
    print_r($invoice);

} catch(Exception $ex) {
    print get_class($ex) . ": " . $ex->getMessage();
}

	}

	 */
