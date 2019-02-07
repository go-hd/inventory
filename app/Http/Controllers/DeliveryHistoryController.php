<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryHistoryRequest;
use App\Models\DeliveryHistory;
use Illuminate\Contracts\Routing\ResponseFactory;

class DeliveryHistoryController extends Controller
{
    /**
     * @var \App\Models\deliveryHistory
     */
    private $deliveryHistory;

    public function __construct(DeliveryHistory $deliveryHistory) {
        $this->deliveryHistory = $deliveryHistory;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $deliveryHistories = $this->deliveryHistory->all();
        return response()->json($deliveryHistories, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $deliveryHistory = $this->deliveryHistory->findOrFail($id);
        return response()->json($deliveryHistory, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  DeliveryHistoryRequest $request
     * @return ResponseFactory
     */
    public function store(DeliveryHistoryRequest $request)
    {
        $this->deliveryHistory->create($request->get('deliveryHistory'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  DeliveryHistoryRequest $request
     * @return ResponseFactory
     */
    public function update($id, DeliveryHistoryRequest $request)
    {
        $deliveryHistory = $this->deliveryHistory->findOrFail($id);
        $deliveryHistory->update($request->get('deliveryHistory'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  DeliveryHistoryRequest $request
     * @return ResponseFactory
     */
    public function destroy($id, DeliveryHistoryRequest $request)
    {
        $deliveryHistory = $this->deliveryHistory->findOrFail($id);
        $deliveryHistory->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
