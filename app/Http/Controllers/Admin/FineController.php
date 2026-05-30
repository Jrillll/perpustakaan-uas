<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::with('borrowing.user', 'borrowing.book')
            ->latest()
            ->get();

        return view('admin.fines.index', compact('fines'));
    }

    public function markPaid(Fine $fine)
    {
        $fine->update([
            'status' => 'paid',
            'paid_at' => now()->toDateString(),
        ]);

        return redirect()->route('admin.fines.index')->with('success', 'Denda berhasil ditandai lunas.');
    }
}
