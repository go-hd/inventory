<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationTypeRequest;
use App\Repositories\LocationType\LocationTypeRepositoryInterface as LocationTypeRepository;

class LocationTypeController extends Controller
{
    /**
     * @var LocationTypeRepository
     */
    private $locationTypeRepository;

    /**
     * 拠点種別コントローラーのインスタンスを作成
     *
     * @param  LocationTypeRepository $locationTypeRepository
     * @return void
     */
    public function __construct(LocationTypeRepository $locationTypeRepository) {
        $this->locationTypeRepository = $locationTypeRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $locationTypes = $this->locationTypeRepository->getList();

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
        $locationType = $this->locationTypeRepository->getOne($id);

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
        $this->locationTypeRepository->store($request->all());
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
        $this->locationTypeRepository->update($id, $request->all());
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
        $this->locationTypeRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
