<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\ApiKey;

class SystemApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try{
            $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();
            if(!is_null($getapikey))
            {
                return $next($request);
            }else{
                return response()->json(['message' => 'Unauthorized access of api!'], 401);
            }

        }catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 401);
        }
    }
}
