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
        $locations = $palette->locations;
        $update = [];
        foreach ($locations as $location) {
            $location_id = $location->id;
            if ($location_id === $data['from_location_id']) {
                $update[$location_id] = ['quantity' => $location->quantity - $data['quantity']];
            } else if ($location_id === $data['to_location_id']) {
                $update[$location_id] = ['quantity' => $location->quantity + $data['quantity']];
            } else {
                $update[$location_id] = ['quantity' => $location->quantity];
            }
        }
        $palette->locations()->sync($update);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
