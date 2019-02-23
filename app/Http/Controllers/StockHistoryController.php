<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockHistoryRequest;
use App\Models\StockHistory;
use Illuminate\Contracts\Routing\ResponseFactory;

class StockHistoryController extends Controller
{
    /**
     * @var \App\Models\StockHistory
     */
    private $stockHistory;

    public function __construct(StockHistory $stockHistory) {
        $this->stockHistory = $stockHistory;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $stockHistorys = $this->stockHistory->all();
        return response()->json($stockHistorys, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $stockHistory = $this->stockHistory->findOrFail($id);
        return response()->json($stockHistory, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  StockHistoryRequest $request
     * @return ResponseFactory
     */
    public function store(StockHistoryRequest $request)
    {
        $this->stockHistory->create($request->get('stockHistory'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  StockHistoryRequest $request
     * @return ResponseFactory
     */
    public function update($id, StockHistoryRequest $request)
    {
        $stockHistory = $this->stockHistory->findOrFail($id);
        $stockHistory->update($request->get('stockHistory'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  StockHistoryRequest $request
     * @return ResponseFactory
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
