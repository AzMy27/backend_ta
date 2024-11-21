<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ApiReportController extends Controller
{
    /**
     * Display a listing of reports with pagination and optional filtering.
     */
    public function index(Request $request)
    {
        return response()->json(['message'=>'Woi apa kabar']);
        
    }

    /**
     * Store a newly created report.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $paths = [];

        try {
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('laporan', 'public');
            }

            $validatedData['images'] = json_encode($paths);
            $reports = Report::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Report created successfully',
                'data' => $reports,
            ], 201);

        } catch (\Exception $e) {
            foreach ($paths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            Log::error("Error creating report: {$e->getMessage()}");
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create report',
            ], 500);
        }
    }

    /**
     * Display the specified report.
     */
    public function show(string $id)
    {
        //  
    }

    /**
     * Update the specified report.
     */
    public function update(Request $request, string $id)
    {
        // 
    }

    /**
     * Remove the specified report.
     */
    public function destroy(string $id)
    {
        // 
    }
}
