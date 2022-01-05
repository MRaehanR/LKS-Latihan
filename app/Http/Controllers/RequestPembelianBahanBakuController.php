<?php

namespace App\Http\Controllers;

use App\Models\RequestPembelianBahanBaku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestPembelianBahanBakuController extends Controller
{

    public function index()
    {
        $data = RequestPembelianBahanBaku::get();

        $response = [
            'message' => 'success',
            'data' => $data
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
                'bahan_baku' => ucwords($request->bahan_baku),
                'jumlah' => $request->jumlah,
                'supplier' => ucwords($request->supplier),
                'departemen' => $request->departemen,                
            ];
            
            $pembelianBahanBaku = RequestPembelianBahanBaku::create($data);
            
            $response = [
                'message' => 'Pembelian Bahan Baku Added',
                'data' => $pembelianBahanBaku,
                // 'log' => $dataFromDb,
                // 'invoice' => $invoice,
                // 'id' => $idBahanBaku->id   
            ];
            
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }   
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
