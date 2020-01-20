<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialMultiRequest;
use App\Http\Requests\MaterialRequest;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->material->query()->orderBy('created_at', 'desc');
        $materials = $request->has('parent_lot_id') ?
            $query->where('parent_lot_id', $request->get('parent_lot_id'))->get() : $query->get();
        $materials->makeHidden(['parent_lot', 'child_lot']);
        return response()->json($materials, 200, [], JSON_PRETTY_PRINT);
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
     * 新規作成 (一括登録)
     * @param MaterialMultiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMulti(MaterialMultiRequest $request)
    {
        DB::beginTransaction();
        try {
            $materials = $request->get('materials');
            $deleted_ids = $request->get('deleted_ids', []);
            foreach ($materials as $material) {
                $targetMaterial = $this->material->where('parent_lot_id', $material['parent_lot_id'])
                    ->where('child_lot_id', $material['child_lot_id'])->first();
                if (empty($targetMaterial)) {
                    $this->material->create($material);
                } else {
                    $targetMaterial->update($material);
                }
            }
            foreach ($deleted_ids as $deleted_id) {
                $this->material->findOrFail($deleted_id)->delete();
            }
            $response = ['status' => 'OK'];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response['status'] = 'NG';
            $response['message'] = $e->getMessage();
            return response()->json($response, 422, [], JSON_PRETTY_PRINT);
        }
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
