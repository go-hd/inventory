<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationTypeRequest;
use App\Models\LocationType;


class LocationTypeController extends Controller
{
    /**
     * @var \App\Models\LocationType
     */
    private $locationType;

    /**
     * LocationTypeControllerの初期化を行う
     *
     * @param \App\Models\LocationType $locationType
     * @return void
     */
    public function __construct(LocationType $locationType) {
        $this->locationType = $locationType;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Routing\ResponseFactory
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
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function show($id)
    {
        $locationType = $this->locationType->findOrFail($id);
        return response()->json($locationType, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  LocationTypeRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function store(LocationTypeRequest $request)
    {
        $this->locationType->create($request->get('locationType'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  LocationTypeRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function update($id, LocationTypeRequest $request)
    {
        $locationType = $this->locationType->findOrFail($id);
        $locationType->update($request->get('locationType'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param  int $id
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function destroy($id)
    {
        $locationType = $this->locationType->findOrFail($id);
        $locationType->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
