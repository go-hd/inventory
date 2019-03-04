<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockHistoryRequest;
use App\StockHistory;

class StockHistoryController extends Controller
{
    /**
     * 在庫履歴のインスタンス
     *
     * @var \App\StockHistory
     */
    private $stockHistory;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param  \App\StockHistory $stockHistory
     * @return void
     */
    public function __construct(StockHistory $stockHistory) {
        $this->stockHistory = $stockHistory;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stockHistories = $this->stockHistory->all();

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
        $stockHistory = $this->stockHistory->findOrFail($id);

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
        $this->stockHistory->create($request->all());
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
        $stockHistory = $this->stockHistory->findOrFail($id);
        $stockHistory->update($request->all());
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
        $stockHistory = $this->stockHistory->findOrFail($id);
        $stockHistory->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
