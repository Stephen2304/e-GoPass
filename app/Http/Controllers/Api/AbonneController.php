<?php

namespace App\Http\Controllers\Api;

use App\Models\Abonne;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbonneResource;
use App\Http\Requests\AbonneRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

/**
 * Class AbonneController
 * @package App\Http\Controllers\Api
 * @group Abonnés
 */
class AbonneController extends Controller
{
    /**
     * Liste des abonnés
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @group Abonnés
     */
    public function index(Request $request) {
        $query = Abonne::query();

        if ($request->has('city')) {
            $query->where('ville', $request->city);
        }

        if ($request->has('search')) {
            $query->where('nom', 'like', "%{$request->search}%")
                  ->orWhere('prenom', 'like', "%{$request->search}%");
        }

        $abonnes = $query->orderBy('created_at', 'desc')->get();
        
        return response()->success(AbonneResource::collection($abonnes), 'Liste des abonnés');
    }

    /**
     * Créer un nouvel abonné
     *
     * @param AbonneRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @group Abonnés
     */
    public function store(AbonneRequest $request) {
        $abonne = Abonne::create($request->validated());
        return response()->success(new AbonneResource($abonne), 'Abonné créé avec succès', 201);
    }

    /**
     * Afficher un abonné
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Abonnés
     */
    public function show($id) {
        $abonne = Abonne::find($id);
        return $abonne ? response()->success(new AbonneResource($abonne), 'Abonné trouvé') : response()->notFoundId('Abonné non trouvé');
    }

    /**
     * Mettre à jour un abonné
     *
     * @param AbonneRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Abonnés
     */
    public function update(AbonneRequest $request, $id) {
        $abonne = Abonne::find($id);
        if (!$abonne) return response()->notFoundId('Abonné non trouvé');
        $abonne->update($request->validated());
        return response()->success(new AbonneResource($abonne), 'Abonné mis à jour');
    }

    /**
     * Supprimer un abonné
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Abonnés
     */
    public function destroy($id) {
        $abonne = Abonne::find($id);
        if (!$abonne) return response()->notFoundId('Abonné non trouvé');
        $abonne->delete();
        return response()->success([], 'Abonné supprimé',204);
    }

    /**
     * Télécharger le PDF d'un abonné
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @group Abonnés
     */
    public function downloadPdf($id)
    {
        $abonne = Abonne::findOrFail($id);
        $pdf = PDF::loadView('pdf.abonne', compact('abonne'));
        return $pdf->download('abonne.pdf');
    }
} 