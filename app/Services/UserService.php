<?php

namespace App\Services;

use App\Models\Profile;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    private $userRepository;
    public function __construct(UserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }
    public function register($request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
            Profile::create(
                [
                    'user_id' => $user->id,
                ]
            );
            DB::commit();
            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token'), 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = JWTAuth::user();

        return response()->json(compact('user', 'token'));
    }
    public function getUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Exception $e) {

            return response()->json(['token_expired'], $e->getMessage());
        } catch (\Exception $e) {

            return response()->json(['token_invalid'], $e->getMessage());
        } catch (\Exception $e) {

            return response()->json(['token_absent'], $e->getMessage());
        }

        $user = JWTAuth::user()->with(['profiles'])->get()->find($user->id);
        return response()->json(compact('user'));
    }
}