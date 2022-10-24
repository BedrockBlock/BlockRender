<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{Block, Transparent};
use pocketmine\block\utils\PillarRotationTrait;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Chain extends Transparent{
	use BlockTypeIdTrait;
	use PillarRotationTrait;

	public function getRequiredStateDataBits() : int{ return 2; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->axis($this->axis);
	}

	public function canBePlaced() : bool{
		return true;
	}
}