<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Execute action with try-catch and logging
     */
    protected function safeExecute(callable $action, string $successMessage, string $errorMessage = 'An unexpected error occurred. Please try again.')
    {
        try {
            $result = $action();

            if (is_string($result)) {
                return redirect()->back()->with('success', $result);
            }

            return $result ?? redirect()->back()->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error($errorMessage . ': ' . $e->getMessage());
            return redirect()->back()->with('error', $errorMessage);
        }
    }
}