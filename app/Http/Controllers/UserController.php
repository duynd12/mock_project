<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $_userService)
    {
        $this->userService = $_userService;
    }

    public function index()
    {
        $users = User::with(['profiles'])->get();
        return view('users.userManager', ['users' => $users]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
    {
        return $this->userService->unlockOrLock($id);
    }

    public function destroy($id)
    {
        //
    }
}
