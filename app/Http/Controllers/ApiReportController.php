<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiReportController extends Controller
{
    /**
     * Display a listing of reports
     */
    public function index()
    {
        try {
            $reportAPI = Report::latest()->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $reportAPI
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch reports'
            ], 500);
        }
    }

    /**
     * Store a newly created report
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'place' => 'required|string|max:255',
                'date' => 'required|date',
                'description' => 'required|string',
                'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $paths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('laporan', 'public');
                    $paths[] = $path;
                }
            }

            $reportAPI = Report::create([
                'title' => $request->title,
                'place' => $request->place,
                'date' => $request->date,
                'description' => $request->description,
                'images' => json_encode($paths)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Report created successfully',
                'data' => $reportAPI
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create report'
            ], 500);
        }
    }

    /**
     * Display the specified report
     */
    public function show(string $id)
    {
        try {
            $reportAPI = Report::findOrFail($id);
            
            return response()->json([
                'status' => 'success',
                'data' => $reportAPI
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Report not found'
            ], 404);
        }
    }

    /**
     * Update the specified report
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'place' => 'required|string|max:255',
                'date' => 'required|date',
                'description' => 'required|string',
                'images.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $reportAPI = Report::findOrFail($id);

            // Update basic information
            $reportAPI->update([
                'title' => $request->title,
                'place' => $request->place,
                'date' => $request->date,
                'description' => $request->description,
            ]);

            // Handle image updates if new images are provided
            if ($request->hasFile('images')) {
                // Delete old images
                $oldImages = json_decode($reportAPI->images, true);
                if ($oldImages) {
                    foreach ($oldImages as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                // Store new images
                $paths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('laporan', 'public');
                    $paths[] = $path;
                }
                
                $reportAPI->update(['images' => json_encode($paths)]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Report updated successfully',
                'data' => $reportAPI
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update report'
            ], 500);
        }
    }

    /**
     * Remove the specified report
     */
    public function destroy(string $id)
    {
        try {
            $reportAPI = Report::findOrFail($id);

            // Delete associated images
            $images = json_decode($reportAPI->images, true);
            if ($images) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $reportAPI->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Report deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete report'
            ], 500);
        }
    }
}