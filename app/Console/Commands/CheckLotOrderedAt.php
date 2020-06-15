<?php

namespace App\Console\Commands;

use App\StockHistoryType;
use Illuminate\Console\Command;
use App\Lot;
use App\StockHistory;

class CheckLotOrderedAt extends Command
{
    private $noticeAcceptance;
    /**
     * ロットのインスタンス
     *
     * @var \App\Lot
     */
    private $lot;
    /**
     * 在庫履歴のインスタンス
     *
     * @var \App\StockHistory
     */
    private $stockHistory;


    /**
     * 登録されているロットの発注日を確認し、当日のものがあれば在庫に反映する
     *
     * @var string
     */
    protected $signature = 'command:check-lot-ordered-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check lot ordered_at';

    public function __construct(Lot $lot, StockHistory $stockHistory)
    {
        parent::__construct();
        $this->lot = $lot;
        $this->stockHistory = $stockHistory;
    }

    public function handle()
    {
        // ordered_atが本日以前で在庫に未反映のロットを取得する
        $lots = $this->lot
            ->orderedAtBeforeToday()
            ->notReflectedInStock()
            ->where('ordered_quantity', '<>', 0)
            ->get();

        $lots->each(function ($lot) {
            // 在庫反映
            $this->stockHistory->create([
                'location_id' => $lot->location_id,
                'lot_id' => $lot->id,
                'stock_history_type_id' => StockHistoryType::RECEIVING,
                'quantity' => $lot->ordered_quantity,
            ]);
            // フラグを反映済みにする
            $lot->update([
                'is_reflected_in_stock' => true
            ]);
        });
    }
}
