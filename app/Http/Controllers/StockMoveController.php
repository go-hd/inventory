<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMoveRequest;
use App\StockMove;

class StockMoveController extends Controller
{
    /**
     * 在庫移動のインスタンス
     *
     * @var \App\StockMove
     */
    private $stockMove;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param  \App\StockMove $stockMove
     * @return void
     */
    public function __construct(StockMove $stockMove) {
        $this->stockMove = $stockMove;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stockMoves = $this->stockMove->all();

        return response()->json($stockMoves, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $stockMove = $this->stockMove->findOrFail($id);

        return response()->json($stockMove, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\StockMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StockMoveRequest $request)
    {
        $this->stockMove->create($request->get('stockMove'));
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\StockMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, StockMoveRequest $request)
    {
        $stockMove = $this->stockMove->findOrFail($id);
        $stockMove->update($request->get('stockMove'));
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
        $stockMove = $this->stockMove->findOrFail($id);
        $stockMove->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
