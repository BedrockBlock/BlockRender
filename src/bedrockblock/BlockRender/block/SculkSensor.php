<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SculkSensor extends Opaque{
	use BlockTypeIdTrait;

	private bool $poweredBit = false;

	public function getRequiredStateDataBits() : int{ return 1; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->poweredBit);
	}

	public function isPoweredBit() : bool{
		return $this->poweredBit;
	}

	public function setPoweredBit(bool $poweredBit) : self{
		$this->poweredBit = $poweredBit;
		return $this;
	}
}