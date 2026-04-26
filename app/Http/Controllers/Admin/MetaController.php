<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MetaController extends Controller
{
    public function register(Request $request) {
        if ($request->hub_mode == "subscribe") {
            $verify_token = "ageraldo6326";
            if ($verify_token = $request->hub_verify_token) {
                return $request->hub_challenge;
            }
        } else {
            return "No Suscribe";
        }

    }  
    
    public function handle(Request $request)
    {
        $data = $request->input('entry.0.changes.0.value');
        
        Log::info($data);
        
        return response()->json(['status' => 'success'], 200);
    }
    
}
