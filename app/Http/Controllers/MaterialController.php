<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Material;

class MaterialController extends Controller
{
    /**
     * レシピのインスタンスを作成
     *
     * @var \App\Material
     */
    private $material;

    /**
     * レシピコントローラーのインスタンスを作成
     *
     * @param  \App\Material $material
     * @return void
     */
    public function __construct(Material $material) {
        $this->material = $material;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $materials = $this->material->all();

        return response()->json($materials, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $material = $this->material->findOrFail($id);

        return response()->json($material, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\MaterialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MaterialRequest $request)
    {
        $this->material->create($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\MaterialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, MaterialRequest $request)
    {
        $material = $this->material->findOrFail($id);
        $material->update($request->all());
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
        $material = $this->material->findOrFail($id);
        $material->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
