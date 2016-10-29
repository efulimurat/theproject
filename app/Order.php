<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\RestController ;

class Order extends Model
{
    //
    private static $transactionsUrl = 'https://testreportingapi.clearsettle.com/api/v3/transactions/list';
    
    protected static function deneme() {
        $rest = new RestController();
        return $rest->getDataFromUrl(self::$transactionsUrl);
    }
}
