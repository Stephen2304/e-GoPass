<?php

namespace App\Http\Controllers\Api;

use App\Models\Voyageur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoyageurResource;
use App\Http\Requests\VoyageurRequest;

/**
 * Class VoyageurController
 * @package App\Http\Controllers\Api
 * @group Voyageurs
 */
class VoyageurController extends Controller
{
    /**
     * Liste des voyageurs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @group Voyageurs
     */
    public function index(Request $request) {
        $query = Voyageur::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->has('search')) {
            $query->where('nom', 'like', "%{$request->search}%")
                  ->orWhere('prenom', 'like', "%{$request->search}%");
        }

        $voyageurs = $query->orderBy('created_at', 'desc')->get();
        
        return response()->success(VoyageurResource::collection($voyageurs), 'Liste des voyageurs');
    }

    /**
     * Créer un nouveau voyageur
     *
     * @param VoyageurRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @group Voyageurs
     */
    public function store(VoyageurRequest $request) {
        $voyageur = Voyageur::create($request->validated());
        return response()->success(new VoyageurResource($voyageur), 'Voyageur créé avec succès', 201);
    }

    /**
     * Afficher un voyageur
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Voyageurs
     */
    public function show($id) {
        $voyageur = Voyageur::find($id);
        return $voyageur ? response()->success(new VoyageurResource($voyageur), 'Voyageur trouvé') : response()->notFoundId('Voyageur non trouvé');
    }

    /**
     * Mettre à jour un voyageur
     *
     * @param VoyageurRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Voyageurs
     */
    public function update(VoyageurRequest $request, $id) {
        $voyageur = Voyageur::find($id);
        if (!$voyageur) return response()->notFoundId('Voyageur non trouvé');
        $voyageur->update($request->validated());
        return response()->success(new VoyageurResource($voyageur), 'Voyageur mis à jour');
    }

    /**
     * Supprimer un voyageur
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Voyageurs
     */
    public function destroy($id) {
        $voyageur = Voyageur::find($id);
        if (!$voyageur) return response()->notFoundId('Voyageur non trouvé');
        $voyageur->delete();
        return response()->success([], 'Voyageur supprimé',204);
    }

    /**
     * Télécharger le PDF d'un voyageur
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @group Voyageurs
     */
    public function downloadPdf($id)
    {
        $voyageur = Voyageur::findOrFail($id);
        $pdf = PDF::loadView('pdf.voyageur', compact('voyageur'));
        return $pdf->download('voyageur.pdf');
    }
} 