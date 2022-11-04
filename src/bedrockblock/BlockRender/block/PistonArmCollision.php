<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{Block, Opaque};
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class PistonArmCollision extends Opaque implements IBlockState{
	use AnyFacingTrait;
	use BlockTypeIdTrait;

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::PISTON_ARM_COLLISION)->writeFacingDirection($this->facing);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setFacing($reader->readFacingDirection());
	}

}