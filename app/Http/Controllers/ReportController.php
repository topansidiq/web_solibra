<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UsersExport;
use App\Exports\BooksExport;
use App\Exports\BorrowsExport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function export(Request $request, $type)
    {
        $year   = $request->year;
        $status = $request->status;
        $format = $request->input('format', 'excel'); // default excel

        switch ($type) {
            case 'users':
                $query = User::query();
                if ($year) {
                    $query->whereYear('created_at', $year);
                }
                $data = $query->get();

                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('admin.reports.users_pdf', compact('data', 'year'));
                    return $pdf->download("users-$year.pdf");
                }

                return Excel::download(new UsersExport($data), "users-$year.xlsx");

            case 'books':
                $query = Book::query();
                if ($year) {
                    $query->whereYear('created_at', $year);
                }
                $data = $query->get();

                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('admin.reports.books_pdf', compact('data', 'year'));
                    return $pdf->download("books-$year.pdf");
                }

                return Excel::download(new BooksExport($data), "books-$year.xlsx");

            case 'borrows':
                $query = Borrow::with(['user', 'book']);
                if ($year) {
                    $query->whereYear('borrowed_at', $year);
                }
                if ($status) {
                    $query->where('status', $status);
                }
                $data = $query->get();

                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('admin.reports.borrows_pdf', compact('data', 'year', 'status'));
                    return $pdf->download("borrows-$year-$status.pdf");
                }

                return Excel::download(new BorrowsExport($data), "borrows-$year-$status.xlsx");

            default:
                return back()->with('error', 'Tipe laporan tidak valid');
        }
    }
}
