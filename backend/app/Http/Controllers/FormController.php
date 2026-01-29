<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\form;

class FormController extends Controller
{
    public function index()
    {
        return response()->json(form::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÀ-ÿ\s-]+$/'],
            'email' => ['required', 'email', 'regex:/\.(nl|com|net|org)$/i'],
            'subject' => 'required|string|max:255',
            'date' => 'date',
            'postcode' => ['required', 'regex:/^\d{4}[A-Za-z]{0,2}$/'],
            'straatnaam' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÀ-ÿ\s-]+$/'],
            'huisnummer' => ['required', 'alpha_num', 'max:10'],
            'phone_number' => ['required', 'digits_between:1,20'],
            'message' => ['required', 'string', 'regex:/^[A-Za-zÀ-ÿ0-9\s.,!?-]+$/'],
    
        ]);

        $form = form::create($validated);

        return response()->json([
            'message' => 'Formulier succesvol verzonden!',
            'id' => $form->id,
        ], 201)
        ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type');
    }
}
