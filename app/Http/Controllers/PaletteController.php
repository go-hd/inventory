<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaletteRequest;
use App\Models\Palette;


class PaletteController extends Controller
{
    /**
     * @var \App\Models\Palette
     */
    private $palette;

    /**
     * PaletteControllerの初期化を行う
     *
     * @param \App\Models\Palette $palette
     * @return void
     */
    public function __construct(Palette $palette) {
        $this->palette = $palette;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function index()
    {
        $palettes = $this->palette->all();
        return response()->json($palettes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function show($id)
    {
        $palette = $this->palette->findOrFail($id);
        return response()->json($palette, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  PaletteRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function store(PaletteRequest $request)
    {
        $this->palette->create($request->get('palette'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  PaletteRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function update($id, PaletteRequest $request)
    {
        $palette = $this->palette->findOrFail($id);
        $palette->update($request->get('palette'));
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
        $palette = $this->palette->findOrFail($id);
        $palette->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
