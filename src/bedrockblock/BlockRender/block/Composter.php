<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Composter extends Opaque{
	use BlockTypeIdTrait;

	private int $fillLevel = 0;

	public function getRequiredStateDataBits() : int{ return 4; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->int(4, $this->fillLevel);
	}

	public function getFillLevel() : int{
		return $this->fillLevel;
	}

	public function setFillLevel(int $level) : self{
		$this->fillLevel = $level;
		return $this;
	}

}