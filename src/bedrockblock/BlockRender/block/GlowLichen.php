<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use bedrockblock\BlockRender\utils\MultiDirectionTrait;

use pocketmine\block\Flowable;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class GlowLichen extends Flowable implements IBlockState{
	use BlockTypeIdTrait;
	use MultiDirectionTrait;

	public function getRequiredStateDataBits() : int{ return 6; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$this->runtimeHelper($w);
	}

	public function encode() : BlockStateWriter{
		return $this->encodeHelper(BlockStateWriter::create(BlockTypeNames::GLOW_LICHEN));
	}

	public function decode(BlockStateReader $reader) : self{
		return $this->decodeHelper(clone $this, $reader);
	}

}