<?php

namespace App\Http\Controllers\Api;

use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaiementRequest;
use App\Http\Resources\PaiementResource;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

/**
 * Class PaiementController
 * @package App\Http\Controllers\Api
 * @group Paiements
 */
class PaiementController extends Controller
{
    /**
     * Liste des paiements
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @group Paiements
     */
    public function index(Request $request) {
        $query = Paiement::query();
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filtrage par mode de paiement
        if ($request->has('mode_paiement')) {
            $query->where('mode_paiement', $request->mode_paiement);
        }

        // Filtrage par reference
        if ($request->has('search')) {
            $query->where('reference', 'like', "%{$request->search}%");
        }

        // Filtrer par numéro de EGoPass si fourni
        if ($request->has('e_go_pass_number')) {
            $query->whereHas('eGoPass', function ($q) use ($request) {
                $q->where('numero', $request->input('e_go_pass_number'));
            });
        }

        // Tri par date décroissante
        $paiements = $query->orderBy('created_at', 'desc')->get();
        
        return response()->success(PaiementResource::collection($paiements), 'Liste des paiements');
    }

    /**
     * Créer un nouveau paiement
     *
     * @param PaiementRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @group Paiements
     */
    public function store(PaiementRequest $request) {
        $data = $request->validated();
        $data['reference'] = Paiement::generateReference(); // Génération de la référence
        $paiement = Paiement::create($data);
        return response()->success(new PaiementResource($paiement), 'Paiement créé avec succès', 201);
    }

    /**
     * Afficher un paiement
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Paiements
     */
    public function show($id) {
        $paiement = Paiement::find($id);
        return $paiement ? response()->success(new PaiementResource($paiement), 'Paiement trouvé') : response()->notFoundId('Paiement non trouvé');
    }

    /**
     * Mettre à jour un paiement
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Paiements
     */
    public function update(Request $request, $id)
    {
        $paiement = Paiement::find($id);
        if (!$paiement) return response()->notFoundId('Paiement non trouvé');

        // Valider uniquement le statut
        $request->validate([
            'statut' => 'required|string',
        ]);

        // Mettre à jour uniquement le statut
        $paiement->update([
            'statut' => $request->statut,
        ]);

        return response()->success(new PaiementResource($paiement), 'Paiement mis à jour');
    }

    /**
     * Supprimer un paiement
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @group Paiements
     */
    public function destroy($id) {
        $paiement = Paiement::find($id);
        if (!$paiement) return response()->notFoundId('Paiement non trouvé');
        $paiement->delete();
        return response()->success([], 'Paiement supprimé',204);
    }

    /**
     * Télécharger le PDF de plusieurs paiements
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @group Paiements
     */
    public function downloadPdf(Request $request)
    {
        $paiements = Paiement::query();

        // Filtrer par e_go_passes_id si fourni
        if ($request->has('e_go_passes_id')) {
            $paiements->where('e_go_passes_id', $request->input('e_go_passes_id'));
        }

        // Récupérer les paiements
        $paiements = $paiements->get();

        // Vérifiez si des paiements existent
        if ($paiements->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Aucun paiement trouvé'], 404);
        }

        // Générer le PDF
        $pdf = PDF::loadView('pdf.paiements', compact('paiements'));

        return $pdf->download('paiements.pdf');
    }
}
