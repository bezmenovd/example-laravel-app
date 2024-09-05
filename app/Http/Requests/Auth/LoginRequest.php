<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $password
 */
class LoginRequest extends FormRequest
{    
    public function rules(): array
    {
        return [
            'email' => 'string|required',
            'password' => 'string|required',
        ];
    }
}
