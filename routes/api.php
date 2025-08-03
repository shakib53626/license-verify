<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->group(function () {

    Route::post('/activate-license', function (Request $request) {
        $license = $request->validate([
            'domain' => 'required|string',
            'status' => 'required|boolean'
        ]);

        cache()->forever('license_verified', [
            'status' => $license['status'],
            'domain' => $license['domain']
        ]);

        return response()->json(['message' => 'License status cached']);
    });

    Route::post('/reset-license', function (Request $request) {
        cache()->forget('license_verified');
        return response()->json(['message' => 'License reset successfully']);
    });

});
