<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class PostNotFoundException extends Exception
{
    protected $message = 'Post not found.';

    public function render(): Response
    {
        return response()->view('errors.404', [
            'message' => $this->getMessage(),
        ])->setStatusCode(404);
    }
}
