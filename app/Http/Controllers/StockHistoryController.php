<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockHistoryRequest;
use App\Repositories\StockHistory\StockHistoryRepositoryInterface as StockHistoryRepository;

class StockHistoryController extends Controller
{
    /**
     * StockHistoryRepository
     */
    private $stockHistoryRepository;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param  StockHistoryRepository $stockHistoryRepository
     * @return void
     */
    public function __construct(StockHistoryRepository $stockHistoryRepository) {
        $this->stockHistoryRepository = $stockHistoryRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stockHistories = $this->stockHistoryRepository->getAll();

        return response()->json($stockHistories, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $stockHistory = $this->stockHistoryRepository->getOne($id);

        return response()->json($stockHistory, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\StockHistoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StockHistoryRequest $request)
    {
        $this->stockHistoryRepository->store($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\StockHistoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, StockHistoryRequest $request)
    {
        $this->stockHistoryRepository->update($id, $request->all());
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
        $this->stockHistoryRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 拠点が保有しているロットの在庫数を取得する
     *
     * @param $location_id
     * @param $lot_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuantity($location_id, $lot_id)
    {
        $res = 0;
        $stockHistories = $this->stockHistoryRepository->getList($location_id, $lot_id);
        foreach ($stockHistories as $stockHistory) {
            $res += $stockHistory->quantity;
        }
        return response()->json(['totalQuantity' => $res], 200, [], JSON_PRETTY_PRINT);
    }
}
