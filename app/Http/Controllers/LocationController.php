<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Location;

class LocationController extends Controller
{
    /**
     * 拠点のインスタンス
     *
     * @var \App\Location
     */
    private $location;

    /**
     * 拠点コントローラーのインスタンスを作成
     *
     * @param  \App\Location $location
     * @return void
     */
    public function __construct(Location $location) {
        $this->location = $location;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $locations = $this->location->all()->makeHidden(['users', 'lots', 'own_palettes', 'palettes']);
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
        $location = $this->location->findOrFail($id);

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
        $this->location->create($request->get('location'));
        $response = ['status' => 'OK'];

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
        $location = $this->location->findOrFail($id);
        $location->update($request->get('location'));
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
        $location = $this->location->findOrFail($id);
        $location->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
