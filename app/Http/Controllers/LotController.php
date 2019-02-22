<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRequest;
use App\Models\Lot;
use Illuminate\Contracts\Routing\ResponseFactory;

class LotController extends Controller
{
    /**
     * @var \App\Models\Lot
     */
    private $lot;

    public function __construct(Lot $lot) {
        $this->lot = $lot;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $lots = $this->lot->all();
        return response()->json($lots, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $lot = $this->lot->findOrFail($id);
        return response()->json($lot, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  LotRequest $request
     * @return ResponseFactory
     */
    public function store(LotRequest $request)
    {
        $this->lot->create($request->get('lot'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  LotRequest $request
     * @return ResponseFactory
     */
    public function update($id, LotRequest $request)
    {
        $lot = $this->lot->findOrFail($id);
        $lot->update($request->get('lot'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  LotRequest $request
     * @return ResponseFactory
     */
    public function destroy($id, LotRequest $request)
    {
        $lot = $this->lot->findOrFail($id);
        $lot->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
