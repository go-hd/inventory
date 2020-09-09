<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaletteMoveRequest;
use App\Repositories\Palette\PaletteRepositoryInterface as PaletteRepository;

class LocationPaletteController extends Controller
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
     * @param  PaletteRepository $paletteRepository
     * @return void
     */
    public function __construct(PaletteRepository $paletteRepository) {
        $this->paletteRepository = $paletteRepository;
    }

    /**
     * パレット個数を移動する
     *
     * @param PaletteMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(PaletteMoveRequest $request)
    {
        $palette = $this->paletteRepository->move(
            $request->get('palette_id'),
            $request->get('location_id'),
            $request->get('quantity')
        );

        $response = ['status' => 'OK', 'palette' => $palette];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
