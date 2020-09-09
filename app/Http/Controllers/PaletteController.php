<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaletteRequest;
use Illuminate\Http\Request;
use App\Repositories\Palette\PaletteRepositoryInterface as PaletteRepository;

class PaletteController extends Controller
{
    /**
     * パレットのインスタンスを作成
     *
     * @var PaletteRepository
     */
    private $paletteRepository;

    /**
     * パレットコントローラーのインスタンスを作成
     *
     * @param PaletteRepository $paletteRepository
     * @return void
     */
    public function __construct(PaletteRepository $paletteRepository) {
        $this->paletteRepository = $paletteRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $palettes = $this->paletteRepository->getList($request->all());

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
        $palette = $this->paletteRepository->getOne($id);

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
        $palette = $this->paletteRepository->store($request->all());
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
        $palette = $this->paletteRepository->update($id, $request->all());
        $response = ['status' => 'OK', 'palette' => $palette];

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
        $this->paletteRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
