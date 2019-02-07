<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Contracts\Routing\ResponseFactory;

class LocationController extends Controller
{
    /**
     * @var \App\Models\Location
     */
    private $location;

    public function __construct(Location $location) {
        $this->location = $location;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $locations = $this->location->all();
        return response()->json($locations, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $location = $this->location->findOrFail($id);
        return response()->json($location, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  LocationRequest $request
     * @return ResponseFactory
     */
    public function store(LocationRequest $request)
    {
        $this->location->create($request->get('location'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  LocationRequest $request
     * @return ResponseFactory
     */
    public function update($id, LocationRequest $request)
    {
        $location = $this->location->findOrFail($id);
        $location->update($request->get('location'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  LocationRequest $request
     * @return ResponseFactory
     */
    public function destroy($id, LocationRequest $request)
    {
        $location = $this->location->findOrFail($id);
        $location->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
