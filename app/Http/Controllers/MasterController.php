<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        try {
            $admins = User::where('role', 'admin')->get();
            $members = User::where('role', 'member')->get();
            $collections = Collection::all();
            return view('master.index', compact('admins', 'members', 'collections'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function admins()
    {
        try {
            $admins = User::where('role', 'admin')->paginate(20);
            return view('master.admins.index', compact('admins'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
