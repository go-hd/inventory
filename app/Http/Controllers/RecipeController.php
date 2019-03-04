<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Recipe;

class RecipeController extends Controller
{
    /**
     * レシピのインスタンスを作成
     *
     * @var \App\Recipe
     */
    private $recipe;

    /**
     * レシピコントローラーのインスタンスを作成
     *
     * @param  \App\Recipe $recipe
     * @return void
     */
    public function __construct(Recipe $recipe) {
        $this->recipe = $recipe;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $recipes = $this->recipe->all();

        return response()->json($recipes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $recipe = $this->recipe->findOrFail($id);

        return response()->json($recipe, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\RecipeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RecipeRequest $request)
    {
        $this->recipe->create($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\RecipeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, RecipeRequest $request)
    {
        $recipe = $this->recipe->findOrFail($id);
        $recipe->update($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
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
