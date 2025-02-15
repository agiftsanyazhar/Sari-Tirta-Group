<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Http, Session};
use PhpParser\Node\Stmt\Echo_;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Login';

        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        try {
            $response = Http::post(url('/api/login'), [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['data'])) {
                Session::put('user', $data['data']);

                // return redirect()->route('dashboard.index')->with('success', 'Login berhasil!');
                return "Login berhasil!";
            } else {
                $errorMessage = $data['message'] ?? 'Login gagal, coba lagi.';

                if (isset($data['errors']['error'])) {
                    $errorMessage = $data['errors']['error'];
                }

                return back()->with('alert', $errorMessage)->withInput();
            }
        } catch (Exception $e) {
            return back()->with('alert', 'Terjadi kesalahan pada server: ' . $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        $token = Session::get('auth_token');

        if ($token) {
            Http::withToken($token)->post(url('/api/logout'));
        }

        Session::forget(['auth_token', 'user']);

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
