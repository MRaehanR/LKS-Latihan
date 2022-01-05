<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanBaku = BahanBaku::get();
        $response = [
            'message' => "Success",
            'data'=> $bahanBaku
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'nama_departemen' => ucwords($request->nama_departemen),
                'bahan_baku' => ucwords($request->bahan_baku),
                'jenis_bahan_baku' => ucwords($request->jenis_bahan_baku)
            ];
            
            $bahanBaku = BahanBaku::create($data);
            $response = [
                'message' => 'Bahan Baku Added',
                'data' => $bahanBaku
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getByCategory(Request $request)
    {
        $category = $request->category;
        
        $bahanBaku = BahanBaku::where('nama_departemen', $category)->get();
        $response = [
            'data'=> $bahanBaku
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        $bahanBaku = BahanBaku::where('nama_departemen', $id)->get();

        $response = [
            'data'=> $bahanBaku
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        try {
            $bahanBaku->update($request->all());
            $response = [
                'message' => 'Bahan Baku updated',
                'data' => $bahanBaku
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        try {
            $bahanBaku->delete();
            $response = [
                'message' => 'Bahan Baku deleted'            
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ]);
        }
    }
}
