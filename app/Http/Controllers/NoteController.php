<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $notite = Note::where('user_id', auth()->id())->latest()->get();
        $notite = Note::where('user_id', Auth::id())->latest()->get();
        return Inertia::render('Notite/Index', [
            'notite' => $notite,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titlu' => 'required|string|max:255',
            'continut' => 'nullable|string',
        ]);

        Note::create([
            'user_id' => auth()->id(),
            'titlu' => $request->titlu,
            'continut' => $request->continut,
        ]);

        return redirect()->back()->with('success', 'Notița a fost adăugată.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $nota = Note::where('user_id', auth()->id())->findOrFail($id);
        $nota->delete();

        return redirect()->back()->with('success', 'Notița a fost ștearsă.');
    }
}
