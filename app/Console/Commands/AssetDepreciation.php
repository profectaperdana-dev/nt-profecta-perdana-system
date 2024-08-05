<?php

namespace App\Console\Commands;

use App\Models\AssetDepreciationModel;
use App\Models\AssetDisposalModel;
use App\Models\AssetModel;
use Illuminate\Console\Command;

use function App\Helpers\changeSaldoKurang;
use function App\Helpers\changeSaldoTambah;
use function App\Helpers\createJournal;
use function App\Helpers\createJournalDetail;

class AssetDepreciation extends Command
{

    protected $signature = 'asset:depreciation';
    protected $description = 'Menghitung dan mencatat penyusutan aset';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // info('Command asset:depreciation is running...');

        $all_assets = AssetModel::with([
            'depreciationBy', 'disposeBy',
            'depreciationBy.journalBy', 'depreciationBy.journalBy.jurnal_detail'
        ])->get();
        foreach ($all_assets as $key => $value) {
            $disposed_amount = AssetDisposalModel::where('asset_id', $value->id)->sum('qty');
            $actual_cost = ($value->acquisition_cost / $value->amount) * ($value->amount - $disposed_amount);

            //lompati asset jika sudah tidak ada lagi cost karena diposal
            if ($actual_cost <= 0) {
                continue;
            }

            $cost_per_month = round($actual_cost / $value->lifetime); //Nilai penyusutan yang akan terjadi

            if ($value->category_id == 2) {
                $coa_code = '1-702'; //Coa Kendaraan
                $coa_akumulasi = '1-802'; //Coa akumulasi penyusutan Kendaraan
                $coa_beban = '5-800'; //Coa beban penyusutan Kendaraan

            } else {
                $coa_code = '1-701'; //Coa Peralatan Kantor
                $coa_akumulasi = '1-801'; //Coa akumulasi penyusutan peralatan
                $coa_beban = '5-700'; //Coa beban penyusutan Peralatan Kantor

            }
            $old_total_depreciation = 0;
            $isDeprecateThisMonth = false;

            foreach ($value->depreciationBy as $key => $dep) {
                $old_total_depreciation += $dep->journalBy->jurnal_detail->sum('debit');
                if (date('Y-m-d', strtotime($dep->journalBy->date)) == date('Y-m-d')) {
                    $isDeprecateThisMonth = true;
                }
            }
            // info('Command asset:depreciation completedwww.' . $value->asset_name);

            //Check apakah penyusutan masih ada
            if ($value->acquisition_cost - ($old_total_depreciation + $cost_per_month) > 0 && !$isDeprecateThisMonth) {
                //Membuat Jurnal Penyusutan
                $deprec = createJournal(
                    date('Y-m-d'),
                    'Penyusutan aset ' . $value->asset_name,
                    $value->warehouse_id
                );
                createJournalDetail($deprec, $coa_beban, $value->asset_code, $cost_per_month, 0);
                createJournalDetail($deprec, $coa_akumulasi, $value->asset_code, 0, $cost_per_month);

                //Simpan jurnal penyusutan
                $createDepreciation = new AssetDepreciationModel();
                $createDepreciation->asset_id = $value->id;
                $createDepreciation->journal_id = $deprec;
                $createDepreciation->save();

                //Update Saldo
                changeSaldoTambah($coa_beban, $value->warehouse_id, $cost_per_month);
                changeSaldoKurang($coa_akumulasi, $value->warehouse_id, $cost_per_month);
            }
        }


        // return 0;
    }
}
