<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Kelp extends Flowable implements IBlockState{
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

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::KELP)->writeInt(BlockStateNames::KELP_AGE, $this->kelpAge);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setKelpAge($reader->readInt(BlockStateNames::KELP_AGE));
	}

}