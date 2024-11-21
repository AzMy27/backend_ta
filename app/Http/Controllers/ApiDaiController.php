<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Model\Dai;

class ApiDaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $daiAPI = Dai::findOrFail($id);

            return repsonse()->json([
                "status"=>"success",
                "data"=>$daiAPI
            ],200);
        }catch(\Exception $e){
            return response()->json([
                "status"=>"error",
                "message"=>"Data not found"
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
