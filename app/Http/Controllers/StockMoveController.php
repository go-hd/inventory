<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMoveRequest;
use App\Models\StockMove;


class StockMoveController extends Controller
{
    /**
     * @var \App\Models\StockMove
     */
    private $stockMove;

    /**
     * StockMoveControllerの初期化を行う
     *
     * @param \App\Models\StockMove $stockMove
     * @return void
     */
    public function __construct(StockMove $stockMove) {
        $this->stockMove = $stockMove;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Routing\ResponseFactory
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
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function show($id)
    {
        $stockMove = $this->stockMove->findOrFail($id);
        return response()->json($stockMove, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  StockMoveRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function store(StockMoveRequest $request)
    {
        $this->stockMove->create($request->get('stockMove'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  StockMoveRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function update($id, StockMoveRequest $request)
    {
        $stockMove = $this->stockMove->findOrFail($id);
        $stockMove->update($request->get('stockMove'));
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
        $stockMove = $this->stockMove->findOrFail($id);
        $stockMove->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
