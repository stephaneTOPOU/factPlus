<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::all();
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
        $data = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|string|email|unique:clients',
            'telephone' => 'required|unique:clients',
            'adresse' => 'required|string',
            'type_client' => 'required|string',
            'date_creation' => 'required|string|date',
        ]);

        try {
            $data = new Clients();
            $data->nom = $request->nom;
            $data->prenom = $request->prenom;
            $data->email = $request->email;
            $data->telephone = $request->telephone;
            $data->adresse = $request->adresse;
            $data->type_client = $request->type_client;
            $data->date_creation = $request->date_creation;
            $data->save();
            return redirect()->back()->with('success', 'Client Ajouté avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $client = Clients::find($clients);
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
        $data = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|string|email|unique:clients',
            'telephone' => 'required|unique:clients',
            'adresse' => 'required|string',
            'type_client' => 'required|string',
            'date_creation' => 'required|string|date',
        ]);

        try {
            $data = Clients::find($clients);

            $data->nom = $request->nom;
            $data->prenom = $request->prenom;
            $data->email = $request->email;
            $data->telephone = $request->telephone;
            $data->adresse = $request->adresse;
            $data->type_client = $request->type_client;
            $data->date_creation = $request->date_creation;
            $data->update();
            return redirect()->back()->with('success', 'Client a été mis à jour avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('success', $e->getMessage());
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
        $client = Clients::find($clients);
        try {
            $client->delete();
            return response()->json(['success' => 'Client supprimé avec succès !']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue'], 500);
        }
    }
}
