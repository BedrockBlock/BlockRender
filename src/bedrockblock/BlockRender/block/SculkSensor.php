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

class SculkSensor extends Opaque implements IBlockState{
	use BlockTypeIdTrait;

	private bool $poweredBit = false;

	public function getRequiredStateDataBits() : int{ return 1; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->poweredBit);
	}

	public function isPoweredBit() : bool{
		return $this->poweredBit;
	}

	public function setPoweredBit(bool $poweredBit) : self{
		$this->poweredBit = $poweredBit;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::SCULK_SENSOR)->writeBool(BlockStateNames::POWERED_BIT, $this->poweredBit);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setPoweredBit($reader->readBool(BlockStateNames::POWERED_BIT));
	}
}