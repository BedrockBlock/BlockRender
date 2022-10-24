<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SculkCatalyst extends Opaque{
	use BlockTypeIdTrait;

	private bool $bloom = false;

	public function getRequiredStateDataBits() : int{ return 1; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->bloom);
	}

	public function isBloom() : bool{
		return $this->bloom;
	}

	public function setBloom(bool $bloom) : self{
		$this->bloom = $bloom;
		return $this;
	}

	public function getLightLevel() : int{
		return 6;
	}
}