<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use Illuminate\Contracts\Routing\ResponseFactory;

class RecipeController extends Controller
{
    /**
     * @var \App\Models\Recipe
     */
    private $recipe;

    public function __construct(Recipe $recipe) {
        $this->recipe = $recipe;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $recipes = $this->recipe->all();
        return response()->json($recipes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $recipe = $this->recipe->findOrFail($id);
        return response()->json($recipe, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  RecipeRequest $request
     * @return ResponseFactory
     */
    public function store(RecipeRequest $request)
    {
        $this->recipe->create($request->get('recipe'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  RecipeRequest $request
     * @return ResponseFactory
     */
    public function update($id, RecipeRequest $request)
    {
        $recipe = $this->recipe->findOrFail($id);
        $recipe->update($request->get('recipe'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  RecipeRequest $request
     * @return ResponseFactory
     * @throws \Exception
     */
    public function destroy($id)
    {
        $recipe = $this->recipe->findOrFail($id);
        $recipe->delete();
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
