<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function index()
    {
        return view('ai.diagnostic');
    }

    public function analyze(Request $request)
    {
        $description = $request->input('description');
        
        // Execute the Python script
        $scriptPath = base_path('app/AI/diagnostic.py');
        $command = "python " . escapeshellarg($scriptPath) . " " . escapeshellarg($description);
        
        $output = shell_exec($command);
        
        return response()->json(json_decode($output, true));
    }
}
