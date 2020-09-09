<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMoveRequest;
use App\StockHistoryType;
use Illuminate\Support\Facades\DB;
use App\Repositories\StockMove\StockMoveRepositoryInterface as StockMoveRepository;
use App\Repositories\StockHistory\StockHistoryRepositoryInterface as StockHistoryRepository;
use App\Repositories\Material\MaterialRepositoryInterface as MaterialRepository;

class StockMoveController extends Controller
{
    /**
     * StockMoveRepository
     */
    private $stockMoveRepository;

    /**
     * @var StockHistoryRepository
     */
    private $stockHistoryRepository;

    /**
     * @var StockHistoryRepository
     */
    private $materialRepository;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param StockMoveRepository $stockMoveRepository
     * @param StockHistoryRepository $stockHistoryRepository
     * @param MaterialRepository $materialRepository
     * @return void
     */
    public function __construct(
        StockMoveRepository $stockMoveRepository,
        StockHistoryRepository $stockHistoryRepository,
        MaterialRepository $materialRepository
    ) {
        $this->stockMoveRepository = $stockMoveRepository;
        $this->stockHistoryRepository = $stockHistoryRepository;
        $this->materialRepository = $materialRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stockMoves = $this->stockMoveRepository->getAll();

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
        $stockMove = $this->stockMoveRepository->getOne($id);

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
        $this->stockMoveRepository->store($request->all());
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
        $this->stockMoveRepository->update($id, $request->all());
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
        $this->stockMoveRepository->destroy($id);
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
            // * 出庫済みステータスにする
            $stockMove = $this->stockMoveRepository->update($id, ['shipping_status' => true]);
            // * 在庫数を更新する
            // 材料から作成の場合
            if ($stockMove->is_from_material) {
                $materials = $this->materialRepository->getList(['parent_lot_id' => $stockMove->lot_id]);

                // 材料分のロットの在庫数を更新する
                foreach ($materials as $material) {
                    $this->stockHistoryRepository->store([
                        'location_id' => $stockMove->shipping_location_id,
                        'lot_id' => $material->child_lot_id,
                        'quantity' => -($material->amount * $stockMove->quantity),
                        'stock_history_type_id' => StockHistoryType::SHIPPING,
                    ]);
                }
            // ロット自体の出庫の場合
            } else {
                // 出庫対象ロットの在庫数を更新する
                $this->stockHistoryRepository->store([
                    'location_id' => $stockMove->shipping_location_id,
                    'lot_id' => $stockMove->lot_id,
                    'quantity' => -$stockMove->quantity,
                    'stock_history_type_id' => StockHistoryType::SHIPPING,
                ]);
            }

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
            // 入庫確認済みステータスにする
            $stockMove = $this->stockMoveRepository->update($id, ['receiving_status' => true]);
            // 在庫数を更新する
            $this->stockHistoryRepository->store([
                'location_id' => $stockMove->receiving_location_id,
                'lot_id' => $stockMove->lot_id,
                'quantity' => $stockMove->quantity,
                'stock_history_type_id' => StockHistoryType::RECEIVING,
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
