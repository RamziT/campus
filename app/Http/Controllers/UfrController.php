<?php

namespace App\Http\Controllers;

use App\Models\UFR;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UfrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ufrs = UFR::all();
        return view('ufrs.index', compact('ufrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universites = Universite::orderBy('libelle')->get();
        return view('ufrs.create', compact('universites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'universite_id' => 'required|exists:universites,id',
            'libelle' => 'required',
            'abreviation' => 'nullable',
            'responsable_id' => 'nullable',
            'contact' => 'nullable',
            'email' => 'nullable',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ufr = new UFR();
        $ufr->universite_id = $request->input('universite_id');
        $ufr->libelle = $request->input('libelle');
        $ufr->abreviation = $request->input('abreviation');
        $ufr->responsable_id = $request->input('responsable_id');
        $ufr->contact = $request->input('contact');
        $ufr->email = $request->input('email');
        $ufr->statut = $request->input('statut');
        $ufr->created_by = 'system';
        $ufr->save();

        return redirect()->route('ufrs.index')->with('success', 'UFR créée avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UFR  $ufr
     * @return \Illuminate\Http\Response
     */
    public function show(UFR $ufr)
    {
        return view('ufrs.show', compact('ufr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UFR  $ufr
     * @return \Illuminate\Http\Response
     */
    public function edit(UFR $ufr)
    {
        $universites = Universite::orderBy('libelle')->get();
        return view('ufrs.edit', compact('ufr', 'universites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UFR  $ufr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UFR $ufr)
    {
        $validator = Validator::make($request->all(), [
            'universite_id' => 'required|exists:universites,id',
            'libelle' => 'required',
            'abreviation' => 'nullable',
            'responsable_id' => 'nullable',
            'contact' => 'nullable',
            'email' => 'nullable',
            'statut' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ufr->universite_id = $request->input('universite_id');
        $ufr->libelle = $request->input('libelle');
        $ufr->abreviation = $request->input('abreviation');
        $ufr->responsable_id = $request->input('responsable_id');
        $ufr->contact = $request->input('contact');
        $ufr->email = $request->input('email');
        $ufr->statut = $request->input('statut');
        $ufr->updated_by = 'system';
        $ufr->save();

        return redirect()->route('ufrs.index')->with('success', 'UFR mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UFR  $ufr
     * @return \Illuminate\Http\Response
     */
    public function destroy(UFR $ufr)
    {
        $ufr->delete();
        return redirect()->route('ufrs.index')->with('success', 'UFR supprimée avec succès');
    }
}
