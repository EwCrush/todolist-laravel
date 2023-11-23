<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Tag;
use App\Models\UserList;
use App\Models\User;
use JD\Cloudder\Facades\Cloudder;

class TodoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('token')){
            return redirect()->route('signin');
        }
        else{
            $access_token = session('token')['access_token'];
            $personalAccessToken = PersonalAccessToken::findToken($access_token);

            if ($personalAccessToken) {
                $user = $personalAccessToken->tokenable;
                $user->image = Cloudder::show('avatar/'. $user->avatar);
                $lists = UserList::where('user', $user->id)->where('type', 'custom')->get();
                $tags = Tag::where('user', $user->id)->get();
                session(['dataTodoMiddleware' => [
                    'user' => $user,
                    'lists' => $lists,
                    'tags' => $tags,
                ]]);
                return $next($request);
            }
            else {
                return redirect()->route('signin');
            }
        }
    }
}
