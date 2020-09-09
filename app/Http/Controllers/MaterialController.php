<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialMultiRequest;
use App\Http\Requests\MaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Material\MaterialRepositoryInterface as MaterialRepository;

class MaterialController extends Controller
{
    /**
     * レシピのインスタンスを作成
     *
     * @var MaterialRepository
     */
    private $materialRepository;

    /**
     * レシピコントローラーのインスタンスを作成
     *
     * @param  MaterialRepository $materialRepository
     * @return void
     */
    public function __construct(MaterialRepository $materialRepository) {
        $this->materialRepository = $materialRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $materials = $this->materialRepository->getList($request->all());

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
        $this->materialRepository->store($request->all());
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
            $this->materialRepository->updateMulti($materials, $deleted_ids);
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
        $this->materialRepository->update($id, $request->all());
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
        $this->materialRepository->delete($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
