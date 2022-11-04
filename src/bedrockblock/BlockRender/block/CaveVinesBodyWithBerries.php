<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use bedrockblock\BlockRender\utils\GrawingAgeTrait;

use pocketmine\block\Flowable;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class CaveVinesBodyWithBerries extends Flowable implements IBlockState{
	use BlockTypeIdTrait;
	use GrawingAgeTrait;

	public function getRequiredStateDataBits() : int{ return 3; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->boundedInt(3, 0, 25, $this->age);
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::CAVE_VINES_BODY_WITH_BERRIES)->writeInt(BlockStateNames::GROWING_PLANT_AGE, $this->age);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setAge($reader->readInt(BlockStateNames::GROWING_PLANT_AGE));
	}

}