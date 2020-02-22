<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRequest;
use App\Lot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LotController extends Controller
{
    /**
     * ロットのインスタンス
     *
     * @var \App\Lot
     */
    private $lot;

    /**
     * ロットコントローラーのインスタンスを作成
     *
     * @param  \App\Lot $lot
     * @return void
     */
    public function __construct(Lot $lot) {
        $this->lot = $lot;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $company_id = $request->get('company_id', null);
        $product_id = $request->get('product_id', null);
        $query = $this->lot->query()->orderBy('created_at', 'desc');
        // 会社にひもづくロットを取得
        if (!is_null($company_id)) {
            $lots = $query->whereHas('product', function ($query) use ($company_id) {
                $query->whereHas('brand', function ($query) use ($company_id) {
                    $query->where('company_id', $company_id);
                });
            })->get();
        // 商品にひもづくロットを取得
        } elseif (!is_null($product_id)) {
            $lots = $query->where('product_id', $product_id)->get();
            // 全ロット取得
        } else {
            $lots = $query->get();
        }

        $lots->makeHidden(['stock_histories', 'product']);

        return response()->json($lots, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $lot = $this->lot->findOrFail($id);

        return response()->json($lot, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\LotRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LotRequest $request)
    {
        $lot = $this->lot->create($request->all());
        $response = ['status' => 'OK', 'lot' => $lot];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\LotRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, LotRequest $request)
    {
        $lot = $this->lot->findOrFail($id);
        $lot->update($request->all());
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
        $lot = $this->lot->findOrFail($id);
        $lot->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
