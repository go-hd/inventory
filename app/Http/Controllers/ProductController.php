<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function index(Request $request)
    {
        $company_id = $request->get('company_id', null);
        $brand_id = $request->get('brand_id', null);
        if (!is_null($company_id)) {
            $products = $this->product->whereHas('brand', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })->get();
        } elseif (!is_null($brand_id)) {
            $products = $this->product->where('brand_id', $brand_id)->get();
        }else {
            $products = $this->product->all();
        }

        $products->makeHidden(['brand']);

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
        $product = $this->product->create($request->all());
        $response = ['status' => 'OK', 'product' => $product];

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
        $response = ['status' => 'OK', 'product' => $product];

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
