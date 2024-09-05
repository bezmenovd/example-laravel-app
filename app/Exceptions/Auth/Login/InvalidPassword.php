<?php

namespace App\Exceptions\Auth\Login;

use Exception;
use Illuminate\Http\Request;

class InvalidPassword extends Exception
{
    public function render(Request $request)
    {
        return response([
            'error' => 'invalid password',
        ], 400);
    }
}
