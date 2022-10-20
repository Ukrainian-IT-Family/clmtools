<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class LecturerMiddleware
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
        if (!User::isUserLecturer()) {
            return response()->json(['error'=> __('authorize.forbidden_by_role')],400);
        }

        if ($request->id) {
            if (
                !User::isUserLectionAuthor($request->id) && strripos($request->route()->getName(), 'lecture')
                || !User::isUserCourseAuthor($request->id) && strripos($request->route()->getName(), 'course')
                || !User::isUserTaskAuthor($request->id) && strripos($request->route()->getName(), 'task')
            ) {
                return response()->json(['error'=> __('authorize.forbidden_by_role')],400);
            }
        }

        return $next($request);
    }

}
