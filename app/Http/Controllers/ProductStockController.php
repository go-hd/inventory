<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStockRequest;
use App\Models\ProductStock;
use Illuminate\Contracts\Routing\ResponseFactory;

class ProductStockController extends Controller
{
    /**
     * @var \App\Models\ProductStock
     */
    private $productStock;

    public function __construct(ProductStock $productStock) {
        $this->productStock = $productStock;
    }

    /**
     * 一覧
     * @return ResponseFactory
     */
    public function index()
    {
        $productStocks = $this->productStock->all();
        return response()->json($productStocks, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * @param  int $id
     * @return ResponseFactory
     */
    public function show($id)
    {
        $productStock = $this->productStock->findOrFail($id);
        return response()->json($productStock, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * @param  ProductStockRequest $request
     * @return ResponseFactory
     */
    public function store(ProductStockRequest $request)
    {
        $this->productStock->create($request->get('productStock'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * @param  int $id
     * @param  ProductStockRequest $request
     * @return ResponseFactory
     */
    public function update($id, ProductStock $request)
    {
        $productStock = $this->productStock->findOrFail($id);
        $productStock->update($request->get('productStock'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * @param  int $id
     * @param  ProductStockRequest $request
     * @return ResponseFactory
     */
    public function destroy($id, ProductStock $request)
    {
        $productStock = $this->productStock->findOrFail($id);
        $productStock->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
