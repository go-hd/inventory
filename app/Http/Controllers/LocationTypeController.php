<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationTypeRequest;
use App\LocationType;

class LocationTypeController extends Controller
{
    /**
     * 拠点種別のインスタンス
     *
     * @var \App\LocationType
     */
    private $locationType;

    /**
     * 拠点種別コントローラーのインスタンスを作成
     *
     * @param  \App\LocationType $locationType
     * @return void
     */
    public function __construct(LocationType $locationType) {
        $this->locationType = $locationType;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $locationTypes = $this->locationType->all();

        return response()->json($locationTypes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $locationType = $this->locationType->findOrFail($id)->setAppends(['locations']);
        return response()->json($locationType, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\LocationTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationTypeRequest $request)
    {
        $this->locationType->create($request->get('locationType'));
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\LocationTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, LocationTypeRequest $request)
    {
        $locationType = $this->locationType->findOrFail($id);
        $locationType->update($request->get('locationType'));
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
        $locationType = $this->locationType->findOrFail($id);
        $locationType->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
