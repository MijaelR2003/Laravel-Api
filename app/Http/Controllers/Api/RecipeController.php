<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Recipe;

use App\Http\Resources\RecipeResource;

class RecipeController extends Controller
{
    public function index(){
        $recipe = Recipe::with('category', 'tags', 'user')->get();
        return RecipeResource::collection($recipe);
    }

    public function store(){
        
    }

    public function show(Recipe $recipe){
        $recipe = $recipe->load('category', 'tags', 'user');
        return new RecipeResource($recipe);
    }

    public function update(){
        
    }

    public function destroy(){

    }
}
