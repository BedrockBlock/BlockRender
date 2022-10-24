<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Kelp extends Flowable{
	use BlockTypeIdTrait;

	private int $kelpAge = 0;

	public function getRequiredStateDataBits() : int{ return 5; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->int($this->getRequiredStateDataBits(), $this->kelpAge);
	}

	public function getKelpAge() : int{
		return $this->kelpAge;
	}

	public function setKelpAge(int $kelpAge) : self{
		$this->kelpAge = $kelpAge;
		return $this;
	}

}