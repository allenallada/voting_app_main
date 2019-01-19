<?php

namespace App\Http\Middleware;

use Closure;
use App\Poll;
use DateTime;

class PollChecker
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
        $polls = Poll::all();
        date_default_timezone_set('Asia/Manila');
        date_default_timezone_set('Asia/Manila');
        
        foreach ($polls as $key => $poll) {
            $current = new DateTime(now());
            $st_dt = new DateTime($poll->start);
            $end_dt = new DateTime($poll->end);
            if($current > $st_dt && $current < $end_dt){
                return $next($request);
            }
        }
        return response(['poll_inactive' => true], 503);
       // return 
    }
}
