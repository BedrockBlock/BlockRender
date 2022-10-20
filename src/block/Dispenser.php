<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use bedrockblock\BlockRender\utils\PlayerYFacingTrait;

use pocketmine\block\Opaque;
use pocketmine\data\runtime\{RuntimeDataReader, RuntimeDataWriter};

class Dispenser extends Opaque{
	use PlayerYFacingTrait;

	public bool $triggeredBit = false;

	public function getRequiredStateDataBits() : int{ return 4; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
		$w->bool($this->triggeredBit);
	}

	public function isTriggeredBit() : bool{
		return $this->triggeredBit;
	}

	public function setTriggeredBit(bool $triggeredBit) : self{
		$this->triggeredBit = $triggeredBit;
		return $this;
	}

}