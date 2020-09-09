<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use App\Repositories\Location\LocationRepositoryInterface as LocationRepository;

class LocationController extends Controller
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * 拠点コントローラーのインスタンスを作成
     *
     * @param  LocationRepository $locationRepository
     * @return void
     */
    public function __construct(LocationRepository $locationRepository) {
        $this->locationRepository = $locationRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $locations = $this->locationRepository->getList($request->all());

        return response()->json($locations, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $location = $this->locationRepository->getOne($id);

        return response()->json($location, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\LocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationRequest $request)
    {
        $location = $this->locationRepository->store($request->all());
        $response = ['status' => 'OK', 'location' => $location];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\LocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, LocationRequest $request)
    {
        $this->locationRepository->update($id, $request->all());
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
        $this->locationRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * フロントからのバリデーション用
     *
     * @param LocationRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function validation(LocationRequest $request) {
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
