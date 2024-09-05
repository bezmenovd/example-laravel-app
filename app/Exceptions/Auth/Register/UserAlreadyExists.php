<?php

namespace App\Exceptions\Auth\Register;

use Exception;
use Illuminate\Http\Request;

class UserAlreadyExists extends Exception
{
    public function render(Request $request)
    {
        return response([
            'error' => 'user already exists',
        ], 403);
    }
}
