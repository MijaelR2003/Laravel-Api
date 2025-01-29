<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;

use Illuminate\Support\Facades\Gate;

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
        $recipe = $request->user()->recipes()->create($request -> all());
        $recipe ->tags()->attach(json_decode($request->tags));

        $recipe -> image = $request-> file('image')->store('recipe', 'public');
        $recipe ->save();
        
        return response()->json(new RecipesResource($recipe), Response::HTTP_CREATED );
    }

    public function show(Recipe $recipe){
        $recipe = $recipe->load('category', 'tags', 'user');
        return new RecipesResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe){
        Gate::authorize('update', $recipe);
        $recipe -> update(($request -> all()));
        if($tags = json_decode($request->tags)){
            $recipe->tags()->sync($tags);
        }
        if($request->file('image')){
            $recipe -> image = $request-> file('image')->store('recipe', 'public');
            $recipe ->save();
        }
        return response()->json(new RecipesResource($recipe), Response::HTTP_OK);
    }

    public function destroy(Recipe $recipe){
        Gate::authorize('delete', $recipe);
        $recipe->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
