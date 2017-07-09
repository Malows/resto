<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ( $request->user()->tipo_usuario_id <= $role ) {
            return $next($request);
        } else {
            abort(403); //not allowed (falta de permisos)
        }
    }
}
