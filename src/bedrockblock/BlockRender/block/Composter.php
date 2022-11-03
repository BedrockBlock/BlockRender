<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Composter extends Opaque implements IBlockState{
	use BlockTypeIdTrait;

	private int $fillLevel = 0;

	public function getRequiredStateDataBits() : int{ return 4; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->int(4, $this->fillLevel);
	}

	public function getFillLevel() : int{
		return $this->fillLevel;
	}

	public function setFillLevel(int $level) : self{
		$this->fillLevel = $level;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::COMPOSTER)->writeInt(BlockStateNames::COMPOSTER_FILL_LEVEL, $this->fillLevel);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setFillLevel($reader->readInt(BlockStateNames::COMPOSTER_FILL_LEVEL));
	}

}