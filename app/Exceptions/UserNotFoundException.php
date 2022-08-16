<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found.';

    public function render(): Response
    {
        return response()->view('errors.404', [
            'message' => $this->getMessage(),
        ])->setStatusCode(404);
    }

    public function renderForConsole(){
        return 'affa';
    }
}
