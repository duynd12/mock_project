<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
{
    private $profileRepository;
    private $userRepository;
    public function __construct(ProfileRepository $_profileRepository, UserRepository $_userRepository)
    {
        $this->profileRepository = $_profileRepository;
        $this->userRepository = $_userRepository;
    }
    public function index()
    {
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return $this->profileRepository->create($data);
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

            $this->userRepository->update([
                'name' => $data['name'],
            ], $user_id);

            $this->profileRepository->update(
                [
                    'numberPhone' => $data['numberPhone'],
                    'address' => $data['address'],
                    'gender' => $data['gender'],
                    'dob' => $data['dob'],
                ],
                $user_id
            );

            DB::commit();
            return response()->json(
                [
                    'message' => 'update success',
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
