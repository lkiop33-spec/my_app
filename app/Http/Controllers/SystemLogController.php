<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\SystemLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        $logs = $query->paginate(20)->withQueryString();
        
        // Get unique model types for filter
        $modelTypes = \App\Models\SystemLog::select('model_type')->distinct()->pluck('model_type');

        return view('system_logs.index', compact('logs', 'modelTypes'));
    }
}
