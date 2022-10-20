<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SculkShrieker extends Opaque{
	use BlockTypeIdTrait;

	private bool $isActive = false;

	private bool $canSummon = false;

	public function getRequiredStateDataBits() : int{ return 2; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->isActive);
		$w->bool($this->canSummon);
	}

	public function isActive() : bool{
		return $this->isActive;
	}

	public function setActive(bool $active) : self{
		$this->isActive = $active;
		return $this;
	}

	public function canSummon() : bool{
		return $this->canSummon;
	}

	public function setSummon(bool $summon) : self{
		$this->canSummon = $summon;
		return $this;
	}

}