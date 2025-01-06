<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Any;

class anggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $sliders =  Anggota::latest()->get();
            if ($sliders->isEmpty()) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'No data available',
                    'data' => $sliders,
                ], 200);
            }
            return response()->json([
                'status' => 'Success',
                'message' => 'Success',
                'data' => $sliders,
            ], 200);
        }catch(Exception $e){
            return response()->json(['status' => 'Failed/Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|unique:tbl_anggota',
                'no_hp' => 'required|string|max:13',
                'alamat' => 'required|string'
            ]);
            if($validator->fails()){
                return response()->json(['status' => 'Error/Failed', 'message' => 'Validation failed', 'detail' => $validator->errors()
                    ], 422);
            }
            $anggota = Anggota::create([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
            return response()->json(['status' => 'Success', 'message' => 'Data successfully saved.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'Failed/Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $slider = Anggota::where('id', $request->id)->first();
            if($slider){
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Success',
                    'data' => $slider,
                ], 200);
            }
            return response()->json([
                'status' => 'Success',
                'message' => 'No data available',
                'data' => $slider,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'Failed/Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string',
                'no_hp' => 'required|string|max:13',
                'alamat' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'Error/Failed', 'message' => 'Validation failed', 'detail' => $validator->errors()], 422);
            }
            $slider = Anggota::where('id', $request->id)->first();
            if (!$slider) {
                return response()->json(['status' => 'Error/Failed', 'message' => 'No data available with your key'], 404);
            }
            $slider->update([
                'name' => $request->name,  
                'email' => $request->email,  
                'no_hp' => $request->no_hp,  
                'alamat' => $request->alamat,  
            ]);
            return response()->json([
                'status' => 'Success',
                'message' => 'Data successfully updated',
                'data' => $slider
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'Failed/Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $deleted = Anggota::where('id', $request->id)->delete();
            if ($deleted) {
                return response()->json(['status' => 'Success', 'message' => 'Data successfully deleted'], 200);
            } else {
                return response()->json(['status' => 'Failed/Error', 'message' => 'Failed to delete'], 500);
            }
            if ($responseData && isset($responseData['status']) && $responseData['status'] === 'Success') {
                return redirect()->back()->with('success', 'Data successfully deleted.');
            }

            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Unknown error occurred';
            return redirect()->back()->with('error', $errorMessage);
        } catch (Exception $e) {
            return response()->json(['status' => 'Failed/Error', 'message' => $e->getMessage()], 500);
        }
    }
}   
