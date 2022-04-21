<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getMethod() === "OPTIONS") {
            $this->setHeaders();
            return response('');
        }
        $this->setHeaders();
        return $next($request); 
    }
    
    private function setHeaders() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Authorization,Content-Type,X-Requested-With,X-CSRF-TOKEN, Set-Cookie');
        header('Access-Control-Allow-Methods: POST,GET,PUT,OPTIONS,DELETE');
    }
}