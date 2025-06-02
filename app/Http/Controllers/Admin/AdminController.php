<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMembers = User::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })->count();

        $totalCommittee = User::whereHas('role', function ($q) {
            $q->where('name', 'panitia');
        })->count();

        $totalFinance = User::whereHas('role', function ($q) {
            $q->where('name', 'tim_keuangan');
        })->count();

        return view('admin.dashboard', compact('totalMembers', 'totalCommittee', 'totalFinance'));
    }

    public function members()
    {
        $members = User::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })->get();

        return view('admin.members.index', compact('members'));
    }

    public function committee()
    {
        $committees = User::whereHas('role', function ($q) {
            $q->where('name', 'panitia');
        })->get();

        return view('admin.committee.index', compact('committees'));
    }

    public function finance()
    {
        $financeTeam = User::whereHas('role', function ($q) {
            $q->where('name', 'tim_keuangan');
        })->get();

        return view('admin.finance.index', compact('financeTeam'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'new_role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->role_id = $request->new_role_id;
        $user->save();

        // Ambil nama role hanya untuk pesan
        $newRoleName = Role::find($request->new_role_id)?->name ?? 'Peran baru';

        return redirect()->back()->with('success', "{$user->name} berhasil diangkat menjadi {$newRoleName}.");
    }
}
