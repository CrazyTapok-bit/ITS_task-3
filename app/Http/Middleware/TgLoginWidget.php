<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TgWebValid\TgWebValid;

class TgLoginWidget
{
    public const ATTR_TOKEN = 'tg_token';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tgWebValid = new TgWebValid(env('TELEGRAM_BOT_TOKEN', ''));
        $loginWidget = $tgWebValid->validateLoginWidget($request->all(), true);
        $request->merge([
            self::ATTR_TOKEN => $loginWidget->id
        ]);
        return $next($request);
    }
}
