<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use bedrockblock\BlockRender\utils\GrawingAgeTrait;

use pocketmine\block\Flowable;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class CaveVinesBodyWithBerries extends Flowable{
	use BlockTypeIdTrait;
	use GrawingAgeTrait;

	public function getRequiredStateDataBits() : int{ return 3; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->boundedInt(3, 0, 25, $this->age);
	}

}