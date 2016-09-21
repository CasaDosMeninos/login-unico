<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use Validator;

use Auth;


class AdminController extends Controller
{

    public function login()
    {
        if (isset($_SESSION['user'])) return redirect()->route('admin');
        return view('login');
    }

    public function index()
    {

        $users = User::procura('*');
        unset($users['count']);
        return view('admin.index', compact('users'));
    }

    public function view($email)
    {
        $user = User::withData($email);

        return view('admin.view', compact('user'));
    }

    public function delete($email)
    {
        User::deleta($email);

        return redirect()->route('admin');
    }
}
