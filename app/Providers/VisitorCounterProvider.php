<?php

namespace App\Providers;

use App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class VisitorCounterProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $data = [];
        $ip = $request->ip();
        $file = 'visitor.json';
        $destinationPath=public_path()."/visitor/json/";
        $json = [];
        $data[$ip] = ["ip" => $ip, "datetime" => now()];
        if(File::exists($destinationPath.$file)) {
            $json = json_decode(file_get_contents($destinationPath.$file), true);
            if($json == null) {
                $json = [];
            }
            if(array_key_exists($ip, $json)) {
                $data = array_merge([], $json);
            } else if(!array_key_exists($ip, $json)) {
                $data = array_merge($data, $json);
            }
        }
        $data = json_encode($data);
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        File::put($destinationPath.$file,$data);
        view()->share('visitors', $json);
        // dd($json);
    }
}
