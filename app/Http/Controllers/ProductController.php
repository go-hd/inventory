<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;

class ProductController extends Controller
{
    /**
     * 商品のインスタンス
     *
     * @var \App\product
     */
    private $product;

    /**
     * 商品コントローラーのインスタンスを作成
     *
     * @param  \App\product $product
     * @return void
     */
    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = $this->product->all();

        return response()->json($products, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = $this->product->findOrFail($id);

        return response()->json($product, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\productRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(productRequest $request)
    {
        $this->product->create($request->all());
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\productRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, productRequest $request)
    {
        $product = $this->product->findOrFail($id);
        $product->update($request->all());
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
        $product = $this->product->findOrFail($id);
        $product->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
