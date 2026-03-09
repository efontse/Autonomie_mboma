<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/connexion')->with('error', 'Veuillez vous connecter.');
        }

        $user = Auth::user();

        // Vérifier si le rôle de l'utilisateur est dans les rôles autorisés
        if (!in_array($user->role, $roles)) {
            abort(403, 'Vous n\'avez pas accès à cette page.');
        }

        return $next($request);
    }
}
