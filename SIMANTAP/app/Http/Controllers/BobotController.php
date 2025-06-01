<?php

namespace App\Http\Controllers;

use App\Models\BobotModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BobotController extends Controller
{
    public function index()
    {
        $activeMenu = 'bobot';
        $bobot = BobotModel::all();
        return view('bobot.index', [
            'title' => 'Manajemen Bobot',
            'bobot' => $bobot,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Manajemen Prioritas Perbaikan', 'url' => '/bobot']
            ]
        ]);
    }

    public function list(Request $request)
    {
        $bobot = BobotModel::select('bobot_id', 'nama_parameter', 'bobot');
        
        if ($request->bobot_id) {
            $bobot->where('bobot_id', $request->bobot_id);
        }

        return DataTables::of($bobot)
            ->addIndexColumn()
            // ->addColumn('action', function ($bobot) {
            //     return '<a href="'.route('bobot.show', $bobot->bobot_id).'" class="btn btn-sm btn-info">
            //     <i class="mdi mdi-pencil"></i>
            //     Detail</a>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }

    public function edit()
    {
        $bobot = BobotModel::all();
        return view('bobot.edit', compact('bobot'));
    }

    public function updateAll(Request $request)
    {
        $bobotInput = $request->input('bobot');
        $total = 0;
        foreach ($bobotInput as $val) {
            $total += floatval($val);
        }

        if (abs($total - 1) > 0.001) {
            return response()->json([
                'status' => false,
                'message' => 'Total bobot harus = 1'
            ]);
        }

        foreach ($bobotInput as $id => $val) {
            BobotModel::where('bobot_id', $id)->update(['bobot' => $val]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Bobot berhasil diperbarui'
        ]);
    }
}