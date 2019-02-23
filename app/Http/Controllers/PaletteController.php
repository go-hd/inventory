<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaletteRequest;
use App\Models\Palette;
use Illuminate\Contracts\Routing\ResponseFactory;

class PaletteController extends Controller
{
    /**
     * @var \App\Models\Palette
     */
    private $palette;

    public function __construct(Palette $palette) {
        $this->palette = $palette;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $palettes = $this->palette->all();
        return response()->json($palettes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $palette = $this->palette->findOrFail($id);
        return response()->json($palette, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  PaletteRequest $request
     * @return ResponseFactory
     */
    public function store(PaletteRequest $request)
    {
        $this->palette->create($request->get('palette'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  PaletteRequest $request
     * @return ResponseFactory
     */
    public function update($id, PaletteRequest $request)
    {
        $palette = $this->palette->findOrFail($id);
        $palette->update($request->get('palette'));
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  PaletteRequest $request
     * @return ResponseFactory
     * @throws \Exception
     */
    public function destroy($id)
    {
        $palette = $this->palette->findOrFail($id);
        $palette->delete();
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
