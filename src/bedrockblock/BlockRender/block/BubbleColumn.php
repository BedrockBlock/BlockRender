<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};

class BubbleColumn extends Flowable implements IBlockState{
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

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::BUBBLE_COLUMN)->writeBool(BlockStateNames::DRAG_DOWN, $this->drag_down);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setDragDown($reader->readBool(BlockStateNames::DRAG_DOWN));
	}

}