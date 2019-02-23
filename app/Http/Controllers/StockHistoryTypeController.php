<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockHistoryTypeRequest;
use App\Models\StockHistoryType;
use Illuminate\Contracts\Routing\ResponseFactory;

class StockHistoryTypeController extends Controller
{
    /**
     * @var \App\Models\StockHistoryType
     */
    private $stockHistoryType;

    public function __construct(StockHistoryType $stockHistoryType) {
        $this->stockHistoryType = $stockHistoryType;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $stockHistoryTypes = $this->stockHistoryType->all();
        return response()->json($stockHistoryTypes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        return response()->json($stockHistoryType, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  StockHistoryTypeRequest $request
     * @return ResponseFactory
     */
    public function store(StockHistoryTypeRequest $request)
    {
        $this->stockHistoryType->create($request->get('stockHistoryType'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  StockHistoryTypeRequest $request
     * @return ResponseFactory
     */
    public function update($id, StockHistoryTypeRequest $request)
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        $stockHistoryType->update($request->get('stockHistoryType'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  StockHistoryTypeRequest $request
     * @return ResponseFactory
     * @throws \Exception
     */
    public function destroy($id)
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        $stockHistoryType->delete();
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
