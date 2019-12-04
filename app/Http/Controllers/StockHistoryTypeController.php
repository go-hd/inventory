<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockHistoryTypeRequest;
use App\StockHistoryType;
use Illuminate\Http\Request;

class StockHistoryTypeController extends Controller
{
    /**
     * 在庫履歴のインスタンス
     *
     * @var \App\StockHistoryType
     */
    private $stockHistoryType;

    /**
     * 在庫履歴コントローラーのインスタンスを作成
     *
     * @param  \App\StockHistoryType $stockHistoryType
     * @return void
     */
    public function __construct(StockHistoryType $stockHistoryType) {
        $this->stockHistoryType = $stockHistoryType;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $company_id = $request->get('company_id', null);
        if (!is_null($company_id)) {
            $stockHistoryTypes = $this->stockHistoryType->where('company_id', $company_id)->get()->makeHidden(['stock_histories']);
        }else {
            $stockHistoryTypes = $this->stockHistoryType->all()->makeHidden(['stock_histories']);
        }
        return response()->json($stockHistoryTypes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);

        return response()->json($stockHistoryType, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\StockHistoryTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StockHistoryTypeRequest $request)
    {
        $this->stockHistoryType->create($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\StockHistoryTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, StockHistoryTypeRequest $request)
    {
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        $stockHistoryType->update($request->all());
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
        $stockHistoryType = $this->stockHistoryType->findOrFail($id);
        $stockHistoryType->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
