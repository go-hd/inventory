<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRequest;
use App\Lot;

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
    public function index()
    {
        $lots = $this->lot->all()->makeHidden(['brand', 'location', 'stock_histories']);

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
        $lot = $this->lot->findOrFail($id)->makeHidden(['brand_name', 'location_name']);

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
        $this->lot->create($request->all());
        $response = ['status' => 'OK'];

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
