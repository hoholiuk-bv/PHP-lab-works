<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Reader;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['book', 'reader']);

        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        if ($request->filled('reader_id')) {
            $query->where('reader_id', $request->reader_id);
        }

        if ($request->filled('loan_date_from')) {
            $query->where('loan_date', '>=', $request->loan_date_from);
        }

        if ($request->filled('loan_date_to')) {
            $query->where('loan_date', '<=', $request->loan_date_to);
        }

        $itemsPerPage = $request->get('itemsPerPage', 10);
        $loans = $query->paginate($itemsPerPage);

        $books = Book::all();
        $readers = Reader::all();

        return view('loans.index', compact('loans', 'books', 'readers'));
    }

    public function create()
    {
        $books = Book::all();
        $readers = Reader::all();
        return view('loans.create', compact('books', 'readers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:book,id',
            'reader_id' => 'required|exists:reader,id',
            'loan_date' => 'required|date',
        ]);

        Loan::create($validated);

        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['book', 'reader']);
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $books = Book::all();
        $readers = Reader::all();
        return view('loans.edit', compact('loan', 'books', 'readers'));
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:book,id',
            'reader_id' => 'required|exists:reader,id',
            'loan_date' => 'required|date',
        ]);

        $loan->update($validated);

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }
}
