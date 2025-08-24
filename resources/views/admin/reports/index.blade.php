@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Export Laporan</h2>

    <form method="GET" action="{{ route('reports.export', 'borrows') }}" class="mb-4">
        <h4>Laporan Peminjaman</h4>
        <div class="mb-2">
            <label>Tahun</label>
            <input type="number" name="year" class="form-control" placeholder="2025">
        </div>
        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">-- Semua --</option>
                <option value="confirmed">Confirmed</option>
                <option value="returned">Returned</option>
                <option value="overdue">Overdue</option>
                <option value="archive">Archive</option>
                <option value="extend">Extend</option>
            </select>
        </div>
        <div class="mb-2">
            <label>Format</label>
            <select name="format" class="form-control">
                <option value="excel">Excel</option>
                <option value="pdf">PDF</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Export Peminjaman</button>
    </form>

    <hr>

    <h4>Laporan User</h4>
    <a href="{{ route('reports.export', ['type'=>'users','format'=>'excel']) }}" class="btn btn-success">Excel</a>
    <a href="{{ route('reports.export', ['type'=>'users','format'=>'pdf']) }}" class="btn btn-danger">PDF</a>

    <h4 class="mt-3">Laporan Buku</h4>
    <a href="{{ route('reports.export', ['type'=>'books','format'=>'excel']) }}" class="btn btn-success">Excel</a>
    <a href="{{ route('reports.export', ['type'=>'books','format'=>'pdf']) }}" class="btn btn-danger">PDF</a>
</div>
@endsection
