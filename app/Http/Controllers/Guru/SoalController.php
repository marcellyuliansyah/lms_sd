<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Ujian;

class SoalController extends Controller
{
    public function store(Request $request)
    {
        Soal::create([
            'ujian_id' => $request->ujian_id,
            'pertanyaan' => $request->pertanyaan,
            'opsi' => $request->opsi, // ['A'=>'..','B'=>'..','C'=>'..','D'=>'..']
            'jawaban_benar' => $request->jawaban_benar
        ]);
        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $soal = Soal::findOrFail($id);
        $soal->update($request->only(['pertanyaan', 'opsi', 'jawaban_benar']));
        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);
        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }
}
