<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Transparent;
use pocketmine\block\utils\PillarRotationTrait;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Chain extends Transparent implements IBlockState{
	use BlockTypeIdTrait;
	use PillarRotationTrait;

	public function getRequiredStateDataBits() : int{ return 2; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->axis($this->axis);
	}

	public function canBePlaced() : bool{
		return true;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::CHAIN)->writePillarAxis($this->axis);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setAxis($reader->readPillarAxis());
	}

}