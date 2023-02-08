<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Helmesvs\Notify\Facades\Notify;
use Helmesvs\Notify\Notify as NotifyNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminContrller extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if (Auth::attempt($data)) {
            Notify::success('Đăng Nhập Thành Công');
            return redirect()->route('home.index');
        } else {
            Notify::error('Sai thông tin và mật khẩu');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.create');
    }
    public function createRegister()
    {
        return view('admin.register');
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);

            $result = Admin::create($data);
            if ($result) {
                return redirect()->route('admin.create');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }
    public function edit()
    {
        return view('admin.changePassword');
    }

    public function update(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        $oldPassword = $request->oldPassword;
        $password = $request->password;
        $password_hash = $user->password;

        $check = Hash::check($oldPassword, $password_hash);
        try {
            if ($check) {
                Admin::where('id', '=', $user->id)
                    ->update(['password' => Hash::make($password)]);
                Notify::success('Đổi mật khẩu thành công');
                return redirect()->back();
            } else {
                Notify::error('Mật khẩu cũ không đúng');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Notify::error('Đổi mật khẩu thất bại');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
