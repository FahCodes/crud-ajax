<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    public function ajax()
    {
        $siswa  = Siswa::orderBy('nama', 'asc');
        return DataTables::of($siswa)->make(true);
    }

    public function index(Request $request)
    {
        // $siswa = Siswa::all();
        if($request->ajax()){
            $siswa = Siswa::all();
            return DataTables::of($siswa)
            ->editColumn('image', function( Siswa $siswa){
                return '<img src="'. asset('images/'.$siswa->image) .'" width="100px" height="100px"/>';
            })
            ->addColumn('aksi', function($siswa){
                return view('tombol', ['data' => $siswa]);
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
        }
        
        // return view('index', ['siswa' => $siswa]);
        return view('index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'               => 'required',
            'nama'              => 'required',
            'image'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'nis.required'      => 'Nis Wajib Diisi!',
            'nama.required'     => 'Nama Wajib Diisi!',  
            'image.mimes'       => 'Gambar Harus Berbentuk jpeg,png,jpg,gif,svg!',
            'image.image'       => 'Gambar Harus Berbentuk jpeg,png,jpg,gif,svg!'
        ]);

        $imageName = '';

        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $request['image'] = $imageName;
        Siswa::create([
            'nis'               => $request['nis'],
            'nama'              => $request['nama'],
            'image'             => $imageName
        ]);
        return response()->json([
            'success'  =>  'image uplouded successfully'
        ], 200);
    }
}
