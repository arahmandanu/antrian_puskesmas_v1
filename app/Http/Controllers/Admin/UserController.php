<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email:rfc'],
            'password' => ['required', 'min:6']
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama harus terdiri dari minimal 3 digit karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal 6 digit karakter.'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        if ($user = User::create($validated)) {
            $user->assignRole('admin');
            flash()->success("Berhasil menambahkan user baru");
        } else {
            flash()->error("Berhasil menambahkan user baru");
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            if ($user->hasRole(['super admin'])) {
                throw new \Exception('Tidak bisa menghapus super admin');
            }

            DB::beginTransaction();
            $deleted = $user->delete();
            if (! $deleted) {
                throw new \Exception('User gagal dihapus.');
            }

            DB::commit();
            flash()->success('Berhasil menghapus user');
        } catch (Throwable $e) {
            DB::rollBack();
            flash()->error('Gagal menghapus user: ' . $e->getMessage());
        }

        return back();
    }
}
