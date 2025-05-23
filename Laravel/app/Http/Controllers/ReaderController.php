<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index(Request $request)
    {
        $query = Reader::query();

        if ($request->filled('full_name')) {
            $query->where('full_name', 'like', '%' . $request->full_name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $itemsPerPage = $request->get('itemsPerPage', 10);
        $readers = $query->paginate($itemsPerPage);

        return view('readers.index', compact('readers'));
    }

    public function create()
    {
        return view('readers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:reader,email',
        ]);

        Reader::create($validated);

        return redirect()->route('readers.index')->with('success', 'Reader created.');
    }

    public function show(Reader $reader)
    {
        $reader->load('loans.book');
        return view('readers.show', compact('reader'));
    }

    public function edit(Reader $reader)
    {
        return view('readers.edit', compact('reader'));
    }

    public function update(Request $request, Reader $reader)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:reader,email,' . $reader->id,
        ]);

        $reader->update($validated);

        return redirect()->route('readers.index')->with('success', 'Reader updated.');
    }

    public function destroy(Reader $reader)
    {
        $reader->delete();
        return redirect()->route('readers.index')->with('success', 'Reader deleted.');
    }
}
