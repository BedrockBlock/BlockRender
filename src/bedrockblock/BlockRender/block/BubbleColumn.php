<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class BubbleColumn extends Flowable{
	use BlockTypeIdTrait;

	private bool $drag_down = false;

	public function getRequiredStateDataBits() : int{ return 1; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->drag_down);
	}

	public function isDragDown() : bool{
		return $this->drag_down;
	}

	public function setDragDown(bool $drag_down) : self{
		$this->drag_down = $drag_down;
		return $this;
	}

}