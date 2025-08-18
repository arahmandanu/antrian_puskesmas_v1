<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\LocketStaff;

class LocketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.loket.index', [
            'lokets' => LocketStaff::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!(new LocketStaff)->canCreateLocket()) {
            flash()->error('Total loket sudah maximal.');
            return redirect()->route('admin.loket.index');
        }

        return view('admin.loket.create', [
            'availableLokets' => (new LocketStaff)->availableLocket(),
            'lantaiOptions' => range(1, config('mysite.total_lantai')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'lantai' => 'required|integer|in:' . implode(',', range(1, config('mysite.total_lantai'))),
            'locket_number' => 'required|unique:locket_staff,locket_number|integer|in:' . implode(',', (new LocketStaff)->availableLocket()),
        ]);

        if ($loket = LocketStaff::create($validatedData)) {
            flash()->success('Loket baru berhasil dibuat.');
            return redirect()->route('admin.loket.edit', $loket->id);
        } else {
            flash()->error('Gagal membuat loket baru.');
            return redirect()->route('admin.loket.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LocketStaff $loket)
    {
        return view('admin.loket.edit', [
            'loket' => $loket,
            'availableLokets' => (new LocketStaff)->availableLocket($loket->locket_number),
            'lantaiOptions' => range(1, config('mysite.total_lantai')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocketStaff $loket)
    {
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'lantai' => 'required|integer|in:' . implode(',', range(1, config('mysite.total_lantai'))),
            'locket_number' => 'required|integer|in:' . implode(',', (new LocketStaff)->availableLocket($loket->locket_number)),
        ]);

        if ($loket->update($validatedData)) {
            flash()->success('Loket berhasil diperbarui.');
            return redirect()->route('admin.loket.edit', $loket->id);
        } else {
            flash()->error('Gagal memperbarui loket.');
            return redirect()->route('admin.loket.index');
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
