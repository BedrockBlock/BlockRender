<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use bedrockblock\BlockRender\utils\PlayerYFacingTrait;

use pocketmine\block\Opaque;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class ChainCommandBlock extends Opaque{
	use BlockTypeIdTrait;
	use PlayerYFacingTrait;

	private bool $conditional = false;

	public function getRequiredStateDataBits() : int{ return 4; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
		$w->bool($this->conditional);
	}

	public function isConditional() : bool{
		return $this->conditional;
	}

	public function setConditional(bool $conditional) : self{
		$this->conditional = $conditional;
		return $this;
	}

}