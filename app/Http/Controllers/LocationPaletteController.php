<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaletteMoveRequest;
use App\Http\Requests\PaletteRequest;
use App\Palette;
use Illuminate\Http\Request;

class LocationPaletteController extends Controller
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
     * パレット個数を移動する
     *
     * @param PaletteMoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(PaletteMoveRequest $request)
    {
        $data = $request->all();
        $palette = $this->palette->findOrFail($data['palette_id']);
        if ($palette->locations()->where('locations.id', $data['location_id'])->exists()) {
            $palette->locations()->updateExistingPivot($data['location_id'], ['quantity' => $data['quantity']], false);
        } else {
            $palette->locations()->attach($data['location_id'], ['quantity' => $data['quantity']]);
        }
        $response = ['status' => 'OK', 'palette' => $palette];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
