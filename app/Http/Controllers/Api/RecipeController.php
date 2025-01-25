<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;


use App\Models\Recipe;

use App\Http\Resources\RecipesResource;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    public function index(){
        $recipe = Recipe::with('category', 'tags', 'user')->get();
        return RecipesResource::collection($recipe);
    }

    public function store(StoreRecipeRequest $request){
        $recipe = Recipe::create($request -> all());
        return response()->json(new RecipesResource($recipe), Response::HTTP_CREATED );
    }

    public function show(Recipe $recipe){
        $recipe = $recipe->load('category', 'tags', 'user');
        return new RecipesResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe){
        $recipe -> update(($request -> all()));
        if($tags = json_decode($request->tags)){
            $recipe->tags()->sync($tags);
        }
        return response()->json(new RecipesResource($recipe), Response::HTTP_OK);
    }

    public function destroy(Recipe $recipe){
        $recipe->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
