<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogDomainController extends Controller
{
    public function someMethod(Request $request)
    {
        Log::info('Request Domain: ' . $request->getHost());

    }
}
