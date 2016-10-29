<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuthentication {

    private static $ApiLoginUrl = "https://testreportingapi.clearsettle.com/api/v3/merchant/user/login";

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        // print_R($request);exit;
        if (Auth::guard($guard)->check()) {
            echo "ss";
        }

        return $next($request);
    }

    public static function apiLogin() {
        $email = env("API_EMAIL");
        $password = env("API_PASSWORD");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$ApiLoginUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "email=" . $email . "&password=" . $password);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//        $headers = [
//            'X-Apple-Tz: 0',
//            'X-Apple-Store-Front: 143444,12',
//            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
//            'Accept-Encoding: gzip, deflate',
//            'Accept-Language: en-US,en;q=0.5',
//            'Cache-Control: no-cache',
//            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
//            'Host: www.example.com',
//            'Referer: http://www.example.com/index.php', //Your referrer address
//            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
//            'X-MicrosoftAjax: Delta=true'
//        ];
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec($ch);
        curl_close($ch);

        if ($server_output === false) {
            echo 'Curl hatası: ' . curl_error($ch);
            return false;
        } else {
            return $server_output;
        }
    }

}
