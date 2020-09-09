<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockHistoryTypeRequest;
use Illuminate\Http\Request;
use App\Repositories\StockHistoryType\StockHistoryTypeRepositoryInterface as StockHistoryTypeRepository;

class StockHistoryTypeController extends Controller
{
    /**
     * @var StockHistoryTypeRepository
     */
    private $stockHistoryTypeRepository;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param StockHistoryTypeRepository $stockHistoryTypeRepository
     * @return void
     */
    public function __construct(StockHistoryTypeRepository $stockHistoryTypeRepository) {
        $this->stockHistoryTypeRepository = $stockHistoryTypeRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $stockHistoryTypes = $this->stockHistoryTypeRepository->getList($request->all());

        return response()->json($stockHistoryTypes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $stockHistoryType = $this->stockHistoryTypeRepository->getOne($id);

        return response()->json($stockHistoryType, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\StockHistoryTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StockHistoryTypeRequest $request)
    {
        $this->stockHistoryTypeRepository->store($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\StockHistoryTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, StockHistoryTypeRequest $request)
    {
        $this->stockHistoryTypeRepository->update($id, $request->all());
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
        $this->stockHistoryTypeRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
