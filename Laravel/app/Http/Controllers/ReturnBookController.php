<?php

namespace App\Http\Controllers;

use App\Models\ReturnBook;
use App\Models\Loan;
use Illuminate\Http\Request;

class ReturnBookController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnBook::with('loan.reader', 'loan.book');

        if ($request->filled('loan_id')) {
            $query->where('loan_id', $request->loan_id);
        }

        if ($request->filled('return_date_from')) {
            $query->where('return_date', '>=', $request->return_date_from);
        }

        if ($request->filled('return_date_to')) {
            $query->where('return_date', '<=', $request->return_date_to);
        }

        $itemsPerPage = $request->get('itemsPerPage', 10);
        $returnBooks = $query->paginate($itemsPerPage);

        $loans = Loan::all();

        return view('returns.index', compact('returnBooks', 'loans'));
    }

    public function create()
    {
        $loans = Loan::doesntHave('return_book')->with('book', 'reader')->get();
        return view('returns.create', compact('loans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loan,id|unique:return_book,loan_id',
            'return_date' => 'required|date|after_or_equal:loan.loan_date',
        ]);

        ReturnBook::create($validated);
        return redirect()->route('returns.index')->with('success', 'Return recorded successfully.');
    }

    public function show(ReturnBook $return)
    {
        return view('returns.show', compact('return'));
    }

    public function edit(ReturnBook $return)
    {
        $loans = Loan::with('book', 'reader')->get();
        return view('returns.edit', compact('return', 'loans'));
    }

    public function update(Request $request, ReturnBook $return)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loan,id|unique:return_book,loan_id,' . $return->id,
            'return_date' => 'required|date|after_or_equal:loan.loan_date',
        ]);

        $return->update($validated);
        return redirect()->route('returns.index')->with('success', 'Return updated successfully.');
    }

    public function destroy(ReturnBook $return)
    {
        $return->delete();
        return redirect()->route('returns.index')->with('success', 'Return deleted successfully.');
    }
}
