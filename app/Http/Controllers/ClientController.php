<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::with(['facture', 'devis', 'proformat'])->get();
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validation des champs
    $validatedData = $request->validate([
        'type_client' => 'required|string',
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:clients',
        'telephone' => 'required|regex:/^\+?[0-9]{10,15}$/',
        'adresse' => 'required|string|max:500',
        'entreprise' => 'required_if:type_client,Entreprise|nullable|string|max:255',
    ]);

    Log::info('Requête reçue pour création de client', $validatedData);

    try {
        DB::beginTransaction();

        $client = new Clients();
        $client->type_client = $validatedData['type_client'];
        $client->nom = $validatedData['nom'];
        $client->prenom = $validatedData['prenom'];
        $client->email = $validatedData['email'];
        $client->telephone = $validatedData['telephone'];
        $client->adresse = $validatedData['adresse'];
        $client->entreprise = $validatedData['entreprise'] ?? null;

        $client->save();

        DB::commit();

        return response()->json(['success' => true, 'message' => 'Client enregistré avec succès !'], 200);
    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Erreur d\'enregistrement du client', [
            'erreur' => $e->getMessage(),
            'données' => $validatedData
        ]);
        return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit($clients)
    {
        $client = Clients::with(['facture', 'devis', 'proformat'])->findOrFail($clients);
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $clients)
    {
        // Validation des champs
        $request->validate([
            'type_client' => 'required|string',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $clients,
            'telephone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'adresse' => 'required|string|max:500',
            'entreprise' => 'nullable|string|max:255',
        ]);

        Log::info('Requête reçue pour mise à jour du client', $request->all());

        try {
            DB::beginTransaction();

            $client = Clients::findOrFail($clients);
            $client->type_client = $request->type_client;
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->email = $request->email;
            $client->telephone = $request->telephone;
            $client->adresse = $request->adresse;
            $client->entreprise = $request->entreprise ?? $client->entreprise;

            $client->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Client mis à jour avec succès !'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erreur de mise à jour du client', [
                'erreur' => $e->getMessage(),
                'données' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy($clients)
{
    try {
        $client = Clients::findOrFail($clients); // Utilisation de findOrFail pour gérer l'absence de client
        $client->delete();

        return response()->json(['success' => 'Client supprimé avec succès !'], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Client introuvable'], 404);
    } catch (Exception $e) {
        return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
    }
}
}
