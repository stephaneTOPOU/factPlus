<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function checkEmail(Request $request)
    {
        $email = $request->query('email');

        // Vérifiez si l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Adresse e-mail invalide.'], 422);
        }

        $exists = Clients::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
}
