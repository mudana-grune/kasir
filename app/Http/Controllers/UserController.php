<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $cabang = Auth::user()->cabang_id;
        $params = $request->all();
        $perPage = empty($params['itemsPerPage']) ? 5 : (int) $params['itemsPerPage'];
        $users = User::where('cabang_id', $cabang)->where('role', User::ROLE_KASIR);
        $users = $this->sort($users, $params['sortBy'], $params['sortDesc'], false);
        $users = $this->finalize($users, $perPage);
        $data = new stdClass();
        $data->users = $users;
        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ], 200);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);

        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    private function sort($users, $sortBy, $sortDesc, $multiSort) {
        if ($sortBy) {
            if ($multiSort) {
                foreach($sortBy  as $key => $item){
                    $users->orderBy($item, $sortDesc[$key] === 'true' ? 'desc' : 'asc');
                }
            } else {
                $users->orderBy($sortBy, $sortDesc === 'true' ? 'desc' : 'asc');
            }
        }else{
            $users->orderByDesc('created_at');
        }
        return $users;
    }

    private function finalize($users, $perPage) {
        return $users->paginate($perPage);
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        if($request->password){
            $user->update([
                'name'=>$request->name,
                'username'=> $request->username,
                'password'=> Hash::make($request->password),
                'cabang_id'=> $request->cabang_id,
                'role'=> $request->role,
            ]);
        }else{
            $user->update([
                'name'=>$request->name,
                'username'=> $request->username,
                'cabang_id'=> $request->cabang_id,
                'role'=> $request->role,
            ]);
        }
        return response()->json(['data'=> $user, 'message'=>'Kasir disimpan'], 200);

    }

    public function store(Request $request){
        $user =  User::create([
            'name'=>$request->name,
            'username'=> $request->username,
            'password'=> Hash::make($request->password),
            'cabang_id'=> $request->cabang_id,
            'role'=> $request->role,
        ]);
        return response()->json(['data'=> $user, 'message'=>'Kasir disimpan'], 200);
    }

    public function checkUsername(Request $request){
        $user = User::where('username', $request->username)->first();
        return response()->json(['data'=> $user, 'message'=> 'Success'], 200);
    }

    public function destroy(Request $request){
        try {

            return response()->json(['data'=> User::destroy($request->id), 'message'=> 'User dihapus']);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'message' => 'Gagal menghapus user'], 200);
        }
    }

}
