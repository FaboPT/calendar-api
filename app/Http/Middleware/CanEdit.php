<?php

namespace App\Http\Middleware;

use App\Traits\ResponseAPI;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CanEdit
{
    use ResponseAPI;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param String $table
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $table)
    {
        $resource = DB::table($table)->find($request->id);
        if ($this->isEditable($resource)) {
            return $next($request);
        }
        return $this->error('Access Denied', Response::HTTP_FORBIDDEN);

    }

    private function isEditable(mixed $resource): bool
    {
        return $resource->user_id === Auth::user()->getAuthIdentifier();
    }
}
