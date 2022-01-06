<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PembelianBahanBaku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        // validasi data dari client
        $validator = Validator::make($request->all(), [
            'bahan_baku' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Failed',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            // mengambil data berdasarkan nama bahan baku
            $bahanBaku = BahanBaku::where('bahan_baku', $request->bahan_baku)->first();

            // membuat nomor invoice
            $last_invoice = PembelianBahanBaku::orderBy('no_invoice', 'desc')->first();
            if ($last_invoice == null) {
                $no_invoice = 'INV-00001';
            } else {
                $no_invoice = 'INV-' . sprintf('%05d', substr($last_invoice->no_invoice, -5) + 1);
            }

            // kondisi jika bahan baku yang dibeli lebih dari jumlah yang ada
            if ($bahanBaku->jumlah < $request->jumlah) {
                return response()->json([
                    'message' => 'Failed',
                    'errors' => 'Jumlah bahan baku tidak mencukupi'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            } 

            // variabel untuk membuat data
            $data = [
                'bahan_baku' => ucwords($request->bahan_baku),
                'jumlah' => $request->jumlah,
                'supplier' => ucwords($request->supplier),
                'no_invoice' => $no_invoice,
                'id_bahan_baku' => $bahanBaku->id
            ];
            $pembelianBahanBaku = PembelianBahanBaku::create($data);

            // variabel berisi jumlah data lama dikurang data baru yang dikirimkan dan mengupdate jumlah bahan baku
            $jumlahBahanBaku = $bahanBaku->jumlah - $request->jumlah;
            $bahanBaku->update(['jumlah' => $jumlahBahanBaku]);

            // response ke client
            $response = [
                'message' => 'Pembelian Bahan Baku Added',
                'data' => $pembelianBahanBaku,
            ];
            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed', $e->errorInfo
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function update(Request $request, $id)
    {
        // validasi data dari client
        $validator = Validator::make($request->all(), [
            'bahan_baku' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Failed',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            // mengambil data berdasarkan id
            $pembelianBahanBaku = PembelianBahanBaku::findOrFail($id);
            $pembelianBahanBaku->update($request->all());

            // response ke client
            $response = [
                'message' => 'Pembelian Bahan Baku Updated',
                'data' => $pembelianBahanBaku
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
            $pembelianBahanBaku = PembelianBahanBaku::findOrFail($id);
            $pembelianBahanBaku->delete();

            // response ke client
            $response = [
                'message' => 'Pembelian Bahan Baku Deleted'
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
}
