<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Location;
use Illuminate\Http\Request;
use App\Repositories\Brand\BrandRepositoryInterface as BrandRepository;

class BrandController extends Controller
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * ブランドコントローラーのインスタンスを作成
     *
     * @param  BrandRepository $brandRepository
     * @return void
     */
    public function __construct(BrandRepository $brandRepository) {
        $this->brandRepository = $brandRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $brands = $this->brandRepository->getList($request->all());

        return response()->json($brands, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\ $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandRequest $request)
    {
        $brand = $this->brandRepository->store($request->all());
        $response = ['status' => 'OK', 'brand' => $brand];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\BrandRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, BrandRequest $request)
    {
        $this->brandRepository->update($id, $request->all());
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
        $this->brandRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * ロットが登録されているブランドのみを取得する
     *
     * @param Request $request
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHasLots(Request $request, Location $location) {
        $brands = $this->brandRepository->getListHasLots($location, $request->all());

        return response()->json($brands, 200, [], JSON_PRETTY_PRINT);
    }
}
