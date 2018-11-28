<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Board;

class CheckOwner
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
        $user = Auth::user();
        $id = $request->route('bb');

        if (!$id) {
            flash("권한이 없습니다.");
            return back();
        }
        
        $board = Board::find($id);
        
        if (!$board || $board->user->id != $user->id) {
            flash('권한이 없습니다');
            return back();
        }
        return $next($request);
        
    }
}
