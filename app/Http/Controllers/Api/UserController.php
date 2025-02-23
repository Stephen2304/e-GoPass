<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 * @group Utilisateurs
 */
class  UserController extends Controller
{
    /**
     * Liste des utilisateurs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $query = User::query();
        
        // Filtrage par date
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filtrage par recherche
        if ($request->has('search')) {
            $query->where('nom', 'like', "%{$request->search}%")
                  ->orWhere('prenom', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        // Tri par date décroissante
        $users = $query->orderBy('created_at', 'desc')->get();
        
        return response()->success(UserResource::collection($users), 'Liste des utilisateurs');
    }

    /**
     * Créer un nouvel utilisateur
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request) {
        // Récupérer l'ID du rôle
        $roleId = $request->input('role_id'); // Assurez-vous que le champ 'role_id' est présent dans la requête

        // Créer l'utilisateur
        $user = User::create($request->validated());

        // Assigner le rôle à l'utilisateur
        if ($roleId) {
            $user->assignRole($roleId);
        }

        return response()->success(new UserResource($user), 'Utilisateur créé avec succès', 201);
    }

    /**
     * Afficher un utilisateur
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $user = User::find($id);
        return $user ? response()->success(new UserResource($user), 'Utilisateur trouvé') : response()->notFoundId('Utilisateur non trouvé');
    }

    /**
     * Mettre à jour un utilisateur
     *
     * @param UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id) {
        $user = User::find($id);
        if (!$user) return response()->notFoundId('Utilisateur non trouvé');

        // Mettre à jour l'utilisateur
        $user->update($request->validated());

        // Récupérer l'ID du rôle et l'assigner
        $roleId = $request->input('role_id');
        if ($roleId) {
            $user->syncRoles([$roleId]); // Utilisez syncRoles pour mettre à jour le rôle
        }

        return response()->success(new UserResource($user), 'Utilisateur mis à jour');
    }

    /**
     * Supprimer un utilisateur
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $user = User::find($id);
        if (!$user) return response()->notFoundId('Utilisateur non trouvé');
        $user->delete();
        return response()->success([], 'Utilisateur supprimé',204);
    }
}
