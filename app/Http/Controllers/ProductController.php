<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;

class ProductController extends Controller
{
    /**
     * @var \App\Models\Product
     */
    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $products = $this->product->all();
        return response()->json($products, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $product = $this->product->findOrFail($id);
        return response()->json($product, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  ProductRequest $request
     * @return ResponseFactory
     */
    public function store(ProductRequest $request)
    {
        $this->product->create($request->get('product'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  ProductRequest $request
     * @return ResponseFactory
     */
    public function update($id, ProductRequest $request)
    {
        $product = $this->product->findOrFail($id);
        $product->update($request->get('product'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  ProductRequest $request
     * @return ResponseFactory
     */
    public function destroy($id, ProductRequest $request)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
