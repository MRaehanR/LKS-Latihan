<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\RequestPembelianBahanBaku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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

    
    public function store(Request $request)
    {
        try {   
            // Membuat validasi data         
            $validator = Validator::make($request->all(), [
                'bahan_baku' => 'required|string',
                'jumlah' => 'required|integer',
                'supplier' => 'required|string',
                'departemen' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Failed',
                    'errors' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            
            
            // membuat nomor request
            $last_request = RequestPembelianBahanBaku::orderBy('no_request', 'desc')->first();
            if ($last_request == null) {
                $no_request = 'REQ-00001';
            } else {
                $no_request = 'REQ-' . sprintf('%05d', substr($last_request->no_request, -5) + 1);
            }            
            
            // mengambil data berdasarkan bahan baku dan departemen
            $bahanBaku = BahanBaku::where('bahan_baku', ucwords($request->bahan_baku))->where('nama_departemen', ucwords($request->departemen))->first();
            
            
            // variabel untuk membuat data
            $data = [
                'no_request' => $no_request,
                'bahan_baku' => ucwords($request->bahan_baku),
                'jumlah' => $request->jumlah,
                'supplier' => ucwords($request->supplier),
                'departemen' => ucwords($request->departemen),   
                'id_bahan_baku' => $bahanBaku->id             
            ];    
            
            // membuat data
            $requestPembelianBahanBaku = RequestPembelianBahanBaku::create($data);
            
            // variabel berisi jumlah data lama ditambah data baru yang dikirimkan dan mengupdate jumlah bahan baku
            $jumlahBahanBaku = $bahanBaku->jumlah + $request->jumlah;
            $bahanBaku->update(['jumlah' => $jumlahBahanBaku]);
            
            // response yang akan dikirimkan ke client
            $response = [
                'message' => 'Request Pembelian Bahan Baku Added',
                'data' => $requestPembelianBahanBaku,    
            ];            
            return response()->json($response, Response::HTTP_CREATED);
            
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', 
                'error' => $e->errorInfo,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }   
    }

    
    public function update(Request $request, $id)
    {        
        try {
            // validasi data
            $validator = Validator::make($request->all(), [
                'bahan_baku' => 'required|string',
                'jumlah' => 'required|integer',
                'supplier' => 'required|string',
                'departemen' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Failed',
                    'errors' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            
            // variabel untuk update
            $data = [
                'bahan_baku' => ucwords($request->bahan_baku),
                'jumlah' => $request->jumlah,
                'supplier' => ucwords($request->supplier),
                'departemen' => $request->departemen,
            ];
            $requestPembelianBahanBaku = RequestPembelianBahanBaku::where('id', $id)->update($data);
            
            // response yang akan dikirimkan ke client
            $response = [
                'message' => 'Request Pembelian Bahan Baku Updated',
                'data' => $requestPembelianBahanBaku
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
        try {
            // mengambil data berdasarkan id
            $requestPembelianBahanBaku = RequestPembelianBahanBaku::findOrFail($id);
            $requestPembelianBahanBaku->delete();
            
            // response yang akan dikirimkan ke client
            $response = [
                'message' => 'Request Pembelian Bahan Baku Deleted',
                'data' => $requestPembelianBahanBaku
            ];
            return response()->json($response, Response::HTTP_OK);
            
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    
    
    public function create()
    {
        
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        
    }
}
