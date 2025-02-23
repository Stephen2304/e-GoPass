<?php

namespace App\Http\Controllers\Api;

use App\Models\EGoPass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EGoPassRequest;
use App\Http\Resources\EGoPassResource;

/**
 * Class EGoPassController
 * @package App\Http\Controllers\Api
 * @group e-GoPass
 */
class EGoPassController extends Controller
{
    /**
     * Générer un e-GoPass
     *
     * @param EGoPassRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @group e-GoPass
     */
    public function generate(EGoPassRequest $request)
    {
        // Récupérer l'utilisateur authentifié
        $userId = auth()->id();

        // Ajouter l'utilisateur authentifié au tableau de données validées
        $data = $request->validated();
        $data['user_id'] = $userId;

        // Créer un e-GoPass avec les données validées
        $egopass = EGoPass::create($data);

        // Retourner une réponse avec le e-GoPass généré
        return response()->success(new EGoPassResource($egopass), 'e-GoPass généré avec succès',201);
    }
} 