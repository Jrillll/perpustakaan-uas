<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $summary = [
            'total_borrowings' => Borrowing::count(),
            'approved_borrowings' => Borrowing::where('status', 'approved')->count(),
            'returned_borrowings' => Borrowing::where('status', 'returned')->count(),
            'unpaid_fines' => Fine::where('status', 'unpaid')->count(),
        ];

        $borrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(100)
            ->get();

        return view('admin.reports.index', compact('summary', 'borrowings'));
    }

    public function downloadPdf()
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->get();

        $fines = Fine::with('borrowing.user', 'borrowing.book')->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('borrowings', 'fines'));

        return $pdf->download('laporan-admin.pdf');
    }

    public function downloadExcel()
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->get();

        $filename = 'laporan-admin-' . now()->format('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($borrowings) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Peminjam', 'Buku', 'Tanggal Pinjam', 'Jatuh Tempo', 'Tanggal Kembali', 'Status']);

            foreach ($borrowings as $borrowing) {
                fputcsv($handle, [
                    $borrowing->id,
                    $borrowing->user?->name ?? '-',
                    $borrowing->book?->title ?? '-',
                    $borrowing->borrow_date,
                    $borrowing->due_date,
                    $borrowing->return_date,
                    $borrowing->status,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
