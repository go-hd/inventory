<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * ブランドのインスタンス
     *
     * @var \App\Brand
     */
    private $brand;

    /**
     * ブランドコントローラーのインスタンスを作成
     *
     * @param  \App\Brand $brand
     * @return void
     */
    public function __construct(Brand $brand) {
        $this->brand = $brand;
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
            $brands = $this->brand->where('company_id', $company_id)->orderBy('created_at', 'desc')->get();

        } else {
            $brands = $this->brand->all();
        }

        return response()->json($brands, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $brand = $this->brand->findOrFail($id);

        return response()->json($brand, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\ $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandRequest $request)
    {
        $brand = $this->brand->create($request->all());
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
        $brand = $this->brand->findOrFail($id);
        $brand->update($request->all());
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
        $brand = $this->brand->findOrFail($id);
        $brand->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
