<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\block\utils\{
	FacesOppositePlacingPlayerTrait,
	HorizontalFacingTrait
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class BigDripleaf extends Flowable{
	use BlockTypeIdTrait;
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	public const NONE_TIlT = 'none';
	public const UNSTABLE_TILT = 'unstable';
	public const PARTIAL_TILT = 'partial_tilt';
	public const FULL_TILT = 'full_tilt';

	private bool $isHead = true;

	private string $tilt = self::NONE_TIlT;

	public function getRequiredStateDataBits() : int{ return 3; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->horizontalFacing($this->facing);
		$w->bool($this->isHead);
	}

	public function isHead() : bool{
		return $this->isHead;
	}

	public function setHead(bool $head) : self{
		$this->isHead = $head;
		return $this;
	}

	public function getTilt() : string{
		return $this->tilt;
	}

	public function setTilt(string $tilt) : self{
		$this->tilt = $tilt;
		return $this;
	}

}