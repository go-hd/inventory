<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;


class RecipeController extends Controller
{
    /**
     * @var \App\Models\Recipe
     */
    private $recipe;

    /**
     * RecipeControllerの初期化を行う
     *
     * @param \App\Models\Recipe $recipe
     * @return void
     */
    public function __construct(Recipe $recipe) {
        $this->recipe = $recipe;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Routing\ResponseFactory
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
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function show($id)
    {
        $recipe = $this->recipe->findOrFail($id);
        return response()->json($recipe, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  RecipeRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function store(RecipeRequest $request)
    {
        $this->recipe->create($request->get('recipe'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  RecipeRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function update($id, RecipeRequest $request)
    {
        $recipe = $this->recipe->findOrFail($id);
        $recipe->update($request->get('recipe'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param  int $id
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function destroy($id)
    {
        $recipe = $this->recipe->findOrFail($id);
        $recipe->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
