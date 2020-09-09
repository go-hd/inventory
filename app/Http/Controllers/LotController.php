<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRequest;
use Illuminate\Http\Request;
use App\Repositories\Lot\LotRepositoryInterface as LotRepository;

class LotController extends Controller
{
    /**
     * @var LotRepository
     */
    private $lotRepository;

    /**
     * ロットコントローラーのインスタンスを作成
     *
     * @param  LotRepository $lotRepository
     * @return void
     */
    public function __construct(LotRepository $lotRepository) {
        $this->lotRepository = $lotRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $lots = $this->lotRepository->getList($request->all());

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
        $lot = $this->lotRepository->getOne($id);

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
        $lot = $this->lotRepository->store($request->all());
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
        $this->lotRepository->update($id, $request->all());
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
        $this->lotRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
