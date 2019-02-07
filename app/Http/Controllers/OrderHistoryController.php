<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderHistoryRequest;
use App\Models\OrderHistory;
use Illuminate\Contracts\Routing\ResponseFactory;

class OrderHistoryController extends Controller
{
    /**
     * @var \App\Models\OrderHistory
     */
    private $orderHistory;

    public function __construct(OrderHistory $orderHistory) {
        $this->orderHistory = $orderHistory;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $orderHistoryies = $this->orderHistory->all();
        return response()->json($orderHistoryies, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $orderHistory = $this->orderHistory->findOrFail($id);
        return response()->json($orderHistory, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  OrderHistoryRequest $request
     * @return ResponseFactory
     */
    public function store(OrderHistoryRequest $request)
    {
        $this->orderHistory->create($request->get('orderHistory'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  OrderHistoryRequest $request
     * @return ResponseFactory
     */
    public function update($id, OrderHistoryRequest $request)
    {
        $orderHistory = $this->orderHistory->findOrFail($id);
        $orderHistory->update($request->get('orderHistory'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  OrderHistoryRequest $request
     * @return ResponseFactory
     */
    public function destroy($id, OrderHistoryRequest $request)
    {
        $orderHistory = $this->orderHistory->findOrFail($id);
        $orderHistory->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
