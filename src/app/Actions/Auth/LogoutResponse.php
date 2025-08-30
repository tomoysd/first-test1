<?php
namespace App\Actions\Auth;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        return redirect('/login'); // ←ログアウト後は必ず /login
    }
}
