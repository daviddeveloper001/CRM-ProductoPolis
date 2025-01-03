<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Block;
use App\Models\Customer;
use App\Models\Segmentation;
use App\Enum\TypeCampaignEnum;
use App\Models\SegmentRegister;
use Illuminate\Console\Command;
use App\Factory\BlockActionFactory;
use App\Factory\CampaignActionFactory;
use App\Models\Segment;
use Illuminate\Support\Facades\Log;

class ProcessBlocksCommand extends Command
{
    protected $signature = 'blocks:process';
    protected $description = 'Procesa los bloques cuya fecha start_date coincide con el tiempo actual';

    public function handle()
    {
        $now = Carbon::now()->floorMinute();

        $upperLimit = $now->copy()->addMinutes(2);

        $blocks = Block::whereBetween('start_date', [$now, $upperLimit])->get();


        if ($blocks->isEmpty()) {
            log::info('No hay bloques programados para ejecutarse en este momento.');
            return;
        }

        foreach ($blocks as $block) {


            Segment::create([
                'block_id' => $block->id
            ]);
            

            $campaign = $block->campaign;

            $typeCampaign = CampaignActionFactory::getAction($campaign->type_campaign);


            if ($typeCampaign) {
                try {
                    $typeCampaign->executeCampaign($block);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }
    }
}
