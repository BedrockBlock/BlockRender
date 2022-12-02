<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\block\utils\PillarRotationTrait;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;

class InfestedDeepslate extends Opaque implements IBlockState{
	use PillarRotationTrait;
	use BlockTypeIdTrait;

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::INFESTED_DEEPSLATE)->writePillarAxis($this->getAxis());
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setAxis($reader->readPillarAxis());
	}
}