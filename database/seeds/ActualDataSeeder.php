<?php

use App\Brand;
use App\Company;
use App\Location;
use App\LocationType;
use App\Lot;
use App\Product;
use App\StockHistory;
use App\StockHistoryType;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class ActualDataSeeder
 *
 * スプレッドシートからデータを作成
 */
class ActualDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 一旦テーブルを空にする
        DB::table('companies')->truncate();
        DB::table('brands')->truncate();
        DB::table('products')->truncate();
        DB::table('lots')->truncate();
        DB::table('stock_history_types')->truncate();
        DB::table('stock_histories')->truncate();
        DB::table('location_types')->truncate();
        DB::table('locations')->truncate();
        DB::table('users')->truncate();

        // 下記はここでインサートしてないが依存関係があるので削除しておく
        DB::table('location_palette')->truncate();
        DB::table('materials')->truncate();
        DB::table('palettes')->truncate();
        DB::table('stock_moves')->truncate();

        // 会社
        $companyDataList = CompanyData::getDataList();
        Company::query()->insert($companyDataList);

        // ブランド
        $brandDataList = BrandData::getDataList();
        Brand::query()->insert($brandDataList);

        // 商品
        $productDataList = ProductData::getDataList();
        Product::query()->insert($productDataList);

        // ロット
        $lotDataList = LotData::getDataList();
        Lot::query()->insert($lotDataList);

        // 在庫履歴種別
        $stockHistoryTypeDataList = StockHistoryTypeData::getDataList();
        StockHistoryType::query()->insert($stockHistoryTypeDataList);

        // 在庫履歴
        $stockHistoryDataList = StockHistoryData::getDataList();
        StockHistory::query()->insert($stockHistoryDataList);

        // 拠点種別
        $locationTypeDataList = LocationTypeData::getDataList();
        LocationType::query()->insert($locationTypeDataList);

        // 拠点
        $locationDataList = LocationData::getDataList();
        Location::query()->insert($locationDataList);

        // ユーザー
        $userDataList = UserData::getDataList();
        User::query()->insert($userDataList);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
