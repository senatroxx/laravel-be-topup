<?php

namespace App\Repositories;

use App\Helpers\IdGenerator;

class InvoiceRepository
{
    public static $bankPaymentChannels = [
        "BCA", "BNI", "BRI", "MANDIRI", "PERMATA",
    ];

    public static $retailPaymentChannels = [
        "ALFAMART", "INDOMARET",
    ];

    public static $ewalletPaymentChannels = [
        "OVO", "DANA", "SHOPEEPAY", "LINKAJA",
    ];

    public static function paymentChannels()
    {
        return array_merge(
            self::$bankPaymentChannels,
            self::$retailPaymentChannels,
            self::$ewalletPaymentChannels
        );
    }

    public static function generateRefId()
    {
        return IdGenerator::generate([
            'table' => 'invoices',
            'field' => 'ref_id',
            'length' => 12,
            'prefix' => 'INV-',
        ]);
    }
}
