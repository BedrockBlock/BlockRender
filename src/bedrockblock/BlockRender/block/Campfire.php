<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\block\utils\{
	FacesOppositePlacingPlayerTrait,
	HorizontalFacingTrait
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Campfire extends Opaque{
	use BlockTypeIdTrait;
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	private bool $extinguished = false;

	public function getRequiredStateDataBits() : int{ return 3; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->horizontalFacing($this->facing);
		$w->bool($this->extinguished);
	}

	public function isExtinguished() : bool{
		return $this->extinguished;
	}

	public function setExtinguished(bool $extinguished) : self{
		$this->extinguished = $extinguished;
		return $this;
	}

}