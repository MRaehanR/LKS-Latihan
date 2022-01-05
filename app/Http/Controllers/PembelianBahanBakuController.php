<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PembelianBahanBaku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PembelianBahanBakuController extends Controller
{

    public function index()
    {
        $pembelianBahanBaku = PembelianBahanBaku::get();
        $response = [
            'message' => "Success",
            'data' => $pembelianBahanBaku
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $dataFromDb = PembelianBahanBaku::orderBy('id', 'DESC')->first();
            $idBahanBaku = BahanBaku::where('bahan_baku', $request->bahan_baku)->first();
            
            if ($dataFromDb == null) {
                $invoice = 'INV001';
            } else {                
                $numeric_id = intval(substr($dataFromDb->no_invoice, 3));                         
                $numeric_id++;
                if (mb_strlen($numeric_id) == 1) {
                    $zero_string = '00';
                } elseif (mb_strlen($numeric_id) == 2) {
                    $zero_string = '0';
                } else {
                    $zero_string = '';
                }
                $invoice = 'INV' . $zero_string . $numeric_id;
            }
            
            
            $data = [
                'bahan_baku' => ucwords($request->bahan_baku),
                'jumlah' => $request->jumlah,
                'supplier' => ucwords($request->supplier),
                'no_invoice' => $invoice,
                'id_bahan_baku' => $idBahanBaku->id
            ];
            
            $pembelianBahanBaku = PembelianBahanBaku::create($data);
            
            $response = [
                'message' => 'Pembelian Bahan Baku Added',
                'data' => $pembelianBahanBaku,
                'log' => $dataFromDb,
                'invoice' => $invoice,
                'id' => $idBahanBaku->id   
            ];
            
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    
    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
