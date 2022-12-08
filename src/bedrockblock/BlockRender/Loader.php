<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;

final class Loader extends PluginBase{

	protected function onEnable() : void{
		BlockManager::init();
		ItemManager::init();
		$pool = $this->getServer()->getAsyncPool();
		$pool->addWorkerStartHook(static function(int $worker) use($pool): void{
			$pool->submitTaskToWorker(new class extends AsyncTask{
				public function onRun() : void{
					BlockManager::init();
					ItemManager::init();
				}
			}, $worker);
		});
	}

}
