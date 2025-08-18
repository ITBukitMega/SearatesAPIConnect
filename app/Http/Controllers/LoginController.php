<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login_form');
    }
    
     public function login(Request $request)
    {
        $empId = $request->EmpID;
        $password = md5($request->Password);

        $user = UserLogin::where('EmpID', $empId)
            ->where('Password', $password)
            ->first();

        if ($user) {
            // Simpan ke session
            session(['logged_in' => true, 'EmpID' => $user->EmpID]);
            return redirect('/dashboard-db');
        } else {
            return back()->with('error', 'EmpID atau Password salah');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
