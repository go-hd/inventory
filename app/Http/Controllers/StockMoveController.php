<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMoveRequest;
use App\StockHistory;
use App\StockHistoryType;
use App\StockMove;
use Illuminate\Support\Facades\DB;

class StockMoveController extends Controller
{
    /**
     * 在庫移動のインスタンス
     *
     * @var \App\StockMove
     */
    private $stockMove;
    /**
     * 在庫履歴のインスタンス
     *
     * @var StockHistory
     */
    private $stockHistory;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param  \App\StockMove $stockMove
     * @return void
     */
    public function __construct(StockMove $stockMove, StockHistory $stockHistory) {
        $this->stockMove = $stockMove;
        $this->stockHistory = $stockHistory;
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
        $this->stockMove->create($request->all());
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
        $stockMove->update($request->all());
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

    /**
     * 出庫を完了する
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function shipped($id)
    {
        DB::beginTransaction();
        try {
            $stockMove = $this->stockMove->findOrFail($id);
            // 出庫済みステータスにする
            $stockMove->shipping_status = true;
            $stockMove->save();
            // 在庫数を更新する
            $this->stockHistory->create([
                'location_id' => $stockMove->shipping_location_id,
                'lot_id' => $stockMove->lot_id,
                'quantity' => -$stockMove->quantity,
                'stock_history_type_id' => StockHistoryType::SHIPPING,
            ]);
            $response = ['status' => 'OK'];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response['status'] = 'NG';
            $response['message'] = "システムエラーが発生しました。:{$e->getMessage()}";
            return response()->json($response, 422, [], JSON_PRETTY_PRINT);
        }

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 入庫確認を完了する
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function received($id)
    {
        DB::beginTransaction();
        try {
            $stockMove = $this->stockMove->findOrFail($id);
            // 入庫確認済みステータスにする
            $stockMove->receiving_status = true;
            $stockMove->save();
            // 在庫数を更新する
            $this->stockHistory->create([
                'location_id' => $stockMove->receiving_location_id,
                'lot_id' => $stockMove->lot_id,
                'quantity' => $stockMove->quantity,
                'stock_history_type_id' => StockHistoryType::receivING,
            ]);
            $response = ['status' => 'OK'];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response['status'] = 'NG';
            $response['message'] = "システムエラーが発生しました。:{$e->getMessage()}";
            return response()->json($response, 422, [], JSON_PRETTY_PRINT);
        }

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
