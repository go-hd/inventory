<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaletteRequest;
use App\Palette;
use Illuminate\Http\Request;

class PaletteController extends Controller
{
    /**
     * パレットのインスタンスを作成
     *
     * @var \App\Palette
     */
    private $palette;

    /**
     * パレットコントローラーのインスタンスを作成
     *
     * @param  \App\Palette $palette
     * @return void
     */
    public function __construct(Palette $palette) {
        $this->palette = $palette;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $company_id = $request->get('company_id', null);
        if (!is_null($company_id)) {
            $palettes = $this->palette->whereHas('location', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })->get()->makeHidden(['shared_locations']);
        } else {
            $palettes = $this->palette->all()->makeHidden(['shared_locations']);
        }

        return response()->json($palettes, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $palette = $this->palette->findOrFail($id);

        return response()->json($palette, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\PaletteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaletteRequest $request)
    {
        $palette = $this->palette->create($request->all());
        $response = ['status' => 'OK', 'palette' => $palette];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\PaletteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, PaletteRequest $request)
    {
        $palette = $this->palette->findOrFail($id);
        $palette->update($request->all());
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
        $palette = $this->palette->findOrFail($id);
        $palette->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
