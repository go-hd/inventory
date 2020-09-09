<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface as ProductRepository;
use App\Repositories\StockMove\StockMoveRepositoryInterface as StockMoveRepository;
use App\Repositories\StockHistory\StockHistoryRepositoryInterface as StockHistoryRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var StockMoveRepository
     */
    private $stockMoveRepository;

    /**
     * @var StockHistoryRepository
     */
    private $stockHistoryRepository;

    /**
     * 商品コントローラーのインスタンスを作成
     *
     * @param  ProductRepository $productRepository
     * @param  StockMoveRepository $stockMoveRepository
     * @param  StockHistoryRepository $stockHistoryRepository
     * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        StockMoveRepository $stockMoveRepository,
        StockHistoryRepository $stockHistoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->stockMoveRepository = $stockMoveRepository;
        $this->stockHistoryRepository = $stockHistoryRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->getList($request->all());

        // 在庫情報を付与する場合
        if ($request->has('with_stock')) {
            $location_id = $request->get('location_id');
            $products = $products->toArray();
            foreach ($products as $index => $product) {
                foreach ($product['lots'] as $lot_index => $lot) {
                    // 出庫待ち
                    $products[$index]['lots'][$lot_index]['shipping_tasks'] =
                        $this->stockMoveRepository->getShippingTask($location_id, $lot['id']);
                    // 入庫確認待ち
                    $products[$index]['lots'][$lot_index]['receiving_tasks'] =
                        $this->stockMoveRepository->getReceivingTask($location_id, $lot['id']);
                    // 在庫数
                    $stockQuantity = 0;
                    $stockHistories = $this->stockHistoryRepository->getList($location_id, $lot['id']);
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
        $product = $this->productRepository->getOne($id);

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
        $product = $this->productRepository->store($request->all());
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
        $product = $this->productRepository->update($id, $request->all());
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
        $this->productRepository->destroy($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
