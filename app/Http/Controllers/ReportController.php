<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function index()
    {
        $user =Auth::user();
        if($user->isDesa()){
            $reports = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            })->get();
        }else{
            
        $reports = Report::get();
        }
        // return view('reports.index');
        return view('reports.index',['reports'=>$reports]);        
    }

    public function show(string $id)
    {
        return view('reports.show',['reports'=>$id]);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id->delete();
        return to_route('reports.index');
    }
}
