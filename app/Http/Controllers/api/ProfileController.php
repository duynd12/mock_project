<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
{
    public function index()
    {
        $id = JWTAuth::user()->id;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return Profile::create($data);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request)
    {
        $user = JWTAuth::user();
        $user_id = $user->id;
        $data = $request->all();
        try {
            DB::beginTransaction();
            User::findOrFail($user_id)->update(
                [
                    'name' => $data['name'],
                ]
            );
            $result = Profile::where('user_id', '=', $user_id)->update(
                [
                    'numberPhone' => $data['numberPhone'],
                    'address' => $data['address'],
                    'gender' => $data['gender'],
                    'dob' => $data['dob'],
                ]
            );
            DB::commit();
            return response()->json(
                [
                    'message' => 'update success'
                ]
            );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'message' => $e->getMessage()
                ]
            );
        }
    }
    public function destroy($id)
    {
        //
    }
}