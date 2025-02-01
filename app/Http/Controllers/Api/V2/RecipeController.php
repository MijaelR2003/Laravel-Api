<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;

use App\Models\Recipe;

use App\Http\Resources\RecipesResource;

class RecipeController extends Controller
{
    public function index(){
        $recipe = Recipe::orderBy('id', 'DESC')
            ->with('category', 'tags', 'user')
            ->paginate();
        return RecipesResource::collection($recipe);
    }

}
