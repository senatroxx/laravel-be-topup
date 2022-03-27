<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class Digiflazz
{
    protected static $endpoint = 'https://api.digiflazz.com/v1';

    public static function getPriceList()
    {
        $response = Http::accept('application/json')
            ->post(self::$endpoint . "/price-list", [
                'cmd' => 'prepaid',
                'username' => config('digiflazz.username'),
                'sign' => self::getSign('pricelist'),
            ]);

        return $response->json('data');
    }

    public static function purchase(Product $product, $attributes)
    {
        $attributes['ref_id'] = self::generateRefId();
        // $attributes['buyer_sku_code'] = $product->sku_code; // live
        $attributes['buyer_sku_code'] = 'xld10'; // testing
        $attributes['customer_no'] = '087800001234'; // testing
        $attributes['testing'] = true; // testing
        $attributes['username'] = config('digiflazz.username');
        $attributes['sign'] = self::getSign($attributes['ref_id']);

        $response = Http::post(self::$endpoint . "/transaction", $attributes);

        return $response->json('data');
    }

    public static function deposit($attributes)
    {
        $attributes['sign'] = self::getSign('deposit');
        $attributes['username'] = config('digiflazz.username');

        $response = Http::post(self::$endpoint . "/deposit", $attributes);

        return $response->json('data');
    }

    protected static function getSign($request, $prod = false)
    {
        if ($prod) {
            $config = config('digiflazz.prod_key');
        } else {
            $config = config('digiflazz.dev_key');
        }

        return md5(config('digiflazz.username') . $config . $request);
    }

    public static function generateRefId()
    {
        return IdGenerator::generate([
            'table' => 'transactions',
            'field' => 'ref_id',
            'length' => 12,
            'prefix' => 'TRX-',
        ]);
    }

    public static function translateStatus($status)
    {
        switch ($status) {
            case 'Sukses':
                return 'SUCCESS';

            case 'Pending':
                return 'PENDING';

            case 'Gagal':
                return 'FAILED';
        }
    }
}
