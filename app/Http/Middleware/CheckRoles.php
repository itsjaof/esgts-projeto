<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function Symfony\Component\String\s;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = session('user');

        //dd($user);
        //dd($roles);

        if ((!$user) || !isset($user['role'])) {
            abort(403, 'Acesso Negado: Não Autenticado ou Role Indefinida.');
        }

        $requiredRoles = explode('|', $roles);

        $userRole = strtolower($user['role']);

        if (in_array($userRole, array_map('strtolower', $requiredRoles))) {
             return $next($request);
        }

        abort(403, 'Acesso Negado. Você não tem o papel necessário para esta área.');
    }
}
