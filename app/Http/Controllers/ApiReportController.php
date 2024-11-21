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
        // 
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
            $reportAPI = Report::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Report created successfully',
                'data' => $reportAPI,
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
        // try {    
        //     $validator = Validator::make($request->all(), [
        //         'title' => 'required|string|max:255',
        //         'place' => 'required|string|max:255',
        //         'date' => 'required|date',
        //         'description' => 'required|string',
        //         'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ], [
        //         'images.*.max' => 'Each image must be less than 2MB',
        //         'images.*.mimes' => 'Only JPEG, PNG, and JPG formats are supported',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Validation failed',
        //             'errors' => $validator->errors()
        //         ], 422);
        //     }

        //     $paths = [];
        //     if ($request->hasFile('images')) {
        //         foreach ($request->file('images') as $image) {
        //             $paths[] = $image->store('laporan', 'public');
        //         }
        //     }

        //     $reportAPI = Report::create([
        //         'title' => $request->title,
        //         'place' => $request->place,
        //         'date' => $request->date,
        //         'description' => $request->description,
        //         'images' => json_encode($paths)
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Report created successfully',
        //         'data' => $reportAPI
        //     ], 201);
        // } catch (\Exception $e) {
        //     Log::error("Error creating report: {$e->getMessage()}");
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to create report'
        //     ], 500);
        // }
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
