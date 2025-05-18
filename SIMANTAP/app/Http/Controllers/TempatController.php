<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempatModel;
use App\Models\UnitModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TempatController extends Controller
{
    // Tampilkan popup daftar tempat pada unit tertentu
    public function popup($unit_id)
    {
        $unit = UnitModel::findOrFail($unit_id);
        $tempat = TempatModel::where('unit_id', $unit_id)->get();
        return view('tempat.popup', compact('unit', 'tempat'));
    }

    public function show($unit_id, $tempat_id)
    {
        $unit = \App\Models\UnitModel::findOrFail($unit_id);
        $tempat = \App\Models\TempatModel::findOrFail($tempat_id);
        return view('tempat.show', compact('unit', 'tempat'));
    }

    // Tampilkan form tambah tempat
    public function create($unit_id)
    {
        $unit = UnitModel::findOrFail($unit_id);
        return view('tempat.create', compact('unit'));
    }

    // Simpan tempat baru
    public function store(Request $request, $unit_id)
    {
        $rules = [
            'nama_tempat' => 'required|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors()
            ]);
        }

        $tempat = new TempatModel();
        $tempat->unit_id = $unit_id;
        $tempat->nama_tempat = $request->nama_tempat;
        $tempat->save();

        return response()->json([
            'status' => true,
            'message' => 'Tempat berhasil ditambahkan.'
        ]);
    }

    // Tampilkan form edit tempat
    public function edit($unit_id, $tempat_id)
    {
        $unit = UnitModel::findOrFail($unit_id);
        $tempat = TempatModel::findOrFail($tempat_id);
        return view('tempat.edit', compact('unit', 'tempat'));
    }

    // Update tempat
    public function update(Request $request, $unit_id, $tempat_id)
    {
        $rules = [
            'nama_tempat' => 'required|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors()
            ]);
        }

        $tempat = TempatModel::findOrFail($tempat_id);
        $tempat->nama_tempat = $request->nama_tempat;
        $tempat->save();

        return response()->json([
            'status' => true,
            'message' => 'Tempat berhasil diperbarui.'
        ]);
    }

    // Konfirmasi hapus
    public function confirmDelete($unit_id, $tempat_id)
    {
        $tempat = TempatModel::findOrFail($tempat_id);
        return view('tempat.confirm_delete', compact('tempat', 'unit_id'));
    }

    // Hapus tempat
    public function destroy($unit_id, $tempat_id)
    {
        $tempat = TempatModel::findOrFail($tempat_id);
        $tempat->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tempat berhasil dihapus.'
        ]);
    }
}