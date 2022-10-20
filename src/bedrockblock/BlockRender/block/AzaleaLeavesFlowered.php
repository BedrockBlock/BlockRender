<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class AzaleaLeavesFlowered extends Flowable{
	use BlockTypeIdTrait;

	private bool $persistent_bit = false;

	private bool $update_bit = false;

	public function getRequiredStateDataBits() : int{ return 2; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->persistent_bit);
		$w->bool($this->update_bit);
	}

	public function isPersistentBit() : bool{
		return $this->persistent_bit;
	}

	public function setPersistentBit(bool $persistent_bit) : self{
		$this->persistent_bit = $persistent_bit;
		return $this;
	}

	public function isUpdateBit() : bool{
		return $this->update_bit;
	}

	public function setUpdateBit(bool $update_bit) : self{
		$this->update_bit = $update_bit;
		return $this;
	}

}