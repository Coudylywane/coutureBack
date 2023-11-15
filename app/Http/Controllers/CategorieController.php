<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use App\Models\UniteCategorie;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategorieRequest;

class CategorieController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Nombre d'éléments par page
        $categories = Categorie::paginate($perPage);

        return response()->json($categories);
    }

    //     public function findAll(Request $request)
    // {
    //    return  Categorie::all();
    // }
    
/*
    public function store(CategorieRequest $request){
        return Categorie::create($request->all());
    } */


    public function store(CategorieRequest $request)
    {
        $categorieData = $request->only(['libelle', 'unites']);
        $unitesData = $categorieData['unites'];

        DB::beginTransaction();

        try {
            $categorie = Categorie::create(['libelle' => $categorieData['libelle']]);

            foreach ($unitesData as $uniteData) {
                $unite = Unite::create([
                    'libelle' => $uniteData['libelle'],
                    'etat' => true,
                ]);
                UniteCategorie::create([
                    'categorie_id' => $categorie->id,
                    'unite_id' => $unite->id,
                    'conversion' => 1
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Catégorie et unités créées avec succès']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Erreur lors de la création : ' . $e->getMessage()], 500);
        }
    }



    public function getUnitesForCategorie($categorieId)
    {
        try {
            $unites = UniteCategorie::where('categorie_id', $categorieId)->with('unite')->get();

            return response()->json($unites);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des unités'], 500);
        }
    }

/*     public function destroy($id)
    {
        DB::beginTransaction();
    
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->delete();
            
            // Supprimer également les unités associées à cette catégorie
            $categorie->unites()->delete();
            
            DB::commit();
            
            return response()->json(['message' => 'Catégorie et unités supprimées avec succès']);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['error' => 'Erreur lors de la suppression : ' . $e->getMessage()], 500);
        }
    } */

    public function destroy($id)
    {
        DB::beginTransaction();
    
        try {
            
            $categorie = Categorie::findOrFail($id);
    
            // Récupérer les IDs des unités associées à cette catégorie dans la table unite_categories
            $unitesIds = $categorie->uniteCategories->pluck('unite_id')->toArray();
    
            // Supprimer les enregistrements d'unités dans la table unite_categories
            UniteCategorie::where('categorie_id', $categorie->id)->delete();
    
            // Supprimer chaque unité individuellement dans la table unites
            foreach ($unitesIds as $uniteId) {
                $unite = Unite::findOrFail($uniteId);
                $unite->delete();
                
            }
    
            // Supprimer la catégorie
            $categorie->delete();
    
            DB::commit();
    
            return response()->json(['message' => 'Catégorie et unités supprimées avec succès']);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['error' => 'Erreur lors de la suppression : ' . $e->getMessage()], 500);
        }
    }
    

    




    


    
    




}