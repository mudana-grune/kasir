<?php

namespace App\Http\Controllers;

use App\Cabang;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class CabangController extends Controller
{
    //
    public function index(Request $request){
        $params = $request->all();
        $perPage = empty($params['itemsPerPage']) ? 5 : (int) $params['itemsPerPage'];
        $cabang = Cabang::query();
        $cabang = $this->sort($cabang, $params['sortBy'], $params['sortDesc'], false);
        $cabang = $this->finalize($cabang, $perPage);
        $data = new stdClass();
        $data->cabang = $cabang;
        return response([
            'status'=> 'success',
            'data' => $data
        ],200);

    }

    private function sort($cabang, $sortBy, $sortDesc, $multiSort) {
        if ($sortBy) {
            if ($multiSort) {
                foreach($sortBy  as $key => $item){
                    $cabang->orderBy($item, $sortDesc[$key] === 'true' ? 'desc' : 'asc');
                }
            } else {
                $cabang->orderBy($sortBy, $sortDesc === 'true' ? 'desc' : 'asc');
            }
        }else{
            $cabang->orderByDesc('created_at');
        }
        return $cabang;
    }

    private function finalize($cabang, $perPage) {
        return $cabang->paginate($perPage);
    }

    public function store(Request $request){
        $cabang = Cabang::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'ig' => NULL,
            'telepon' => $request->telepon,
            'email' => $request->email,
        ]);
        return response()->json(['data' => $cabang, 'message'=> 'Cabang baru disimpan']);
    }
    public function update(Request $request, $id){
        $cabang = Cabang::find($id);
        $cabang->update([
            'nama' => $request->nama,
            'alamat'=> $request->alamat,
            'email'=>$request->email,
            'telepon'=>$request->telepon
        ]);
        return response()->json(['data'=> $cabang, 'message'=> 'Cabang berhasil diupdate']);
    }
    public function destroy(Request $request){
        try {
            return response()->json(['data' => Cabang::destroy($request->id), 'message'=> 'Cabang berhasil dihapus']);
        }catch(Exception $e){
            return response()->json(['data' => $e->getMessage(), 'message' => 'Gagal menghapus cabang'], 200);
        }
    }
}
