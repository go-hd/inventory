<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use App\StockHistory;
use App\StockMove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * 商品のインスタンス
     *
     * @var \App\Product
     */
    private $product;
    /**
     * 在庫移動のインスタンス
     *
     * @var \App\StockMove
     */
    private $stockMove;
    /**
     * 在庫履歴のインスタンス
     *
     * @var \App\StockHistory
     */
    private $stockHistory;

    /**
     * 商品コントローラーのインスタンスを作成
     *
     * @param  \App\Product $product
     * @param  \App\StockMove $stockMove
     * @param  \App\StockHistory $stockHistory
     * @return void
     */
    public function __construct(Product $product, StockMove $stockMove, StockHistory $stockHistory) {
        $this->product = $product;
        $this->stockMove = $stockMove;
        $this->stockHistory = $stockHistory;
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

        // 在庫情報を付与する場合
        if ($request->has('with_stock')) {
            $location_id = $request->get('location_id');
            $products = $products->toArray();
            foreach ($products as $index => $product) {
                foreach ($product['lots'] as $lot_index => $lot) {
                    // 出庫待ち
                    $products[$index]['lots'][$lot_index]['shipping_tasks'] =
                        $this->stockMove->getShippingTask($location_id, $lot['id']);
                    // 入庫確認待ち
                    $products[$index]['lots'][$lot_index]['receiving_tasks'] =
                        $this->stockMove->getReceivingTask($location_id, $lot['id']);
                    // 在庫数
                    $stockQuantity = 0;
                    $stockHistories = $this->stockHistory->where('location_id', $location_id)->where('lot_id', $lot['id'])->get();
                    foreach ($stockHistories as $stockHistory) {
                        $stockQuantity += $stockHistory->quantity;
                    }
                    // 在庫が0個のロットは取り除く
                    if ($stockQuantity === 0) {
                        unset($products[$index]['lots'][$lot_index]);
                    } else {
                        $products[$index]['lots'][$lot_index]['stock_quantity'] = $stockQuantity;
                    }
                }
                // ひもづく在庫ロットが0の場合、その商品は取り除く
                if (count($products[$index]['lots']) === 0) {
                    unset($products[$index]);
                }
            }
        }


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
