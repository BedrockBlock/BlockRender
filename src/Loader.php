<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase{

	private BlockManager $manager;

	protected function onEnable() : void{
		$this->manager = new BlockManager();
	}

	public function getManager() : BlockManager{
		return $this->manager;
	}

}