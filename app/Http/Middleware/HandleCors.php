<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\HandleCors as Middleware;

class HandleCors extends Middleware
{
    /**
     * The names of headers that should be added to the CORS allowlist.
     *
     * @var array<int, string>
     */
    protected $addedHeaders = [];

    /**
     * The names of headers that should be removed from the CORS allowlist.
     *
     * @var array<int, string>
     */
    protected $removedHeaders = [];
}
