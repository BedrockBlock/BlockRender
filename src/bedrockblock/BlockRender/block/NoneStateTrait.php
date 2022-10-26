<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\block\Block;

/** @see IBlockState */
trait NoneStateTrait{
	use BlockTypeIdTrait;

	public function encode() : ?BlockStateWriter{
		return null;
	}

	public function decode(BlockStateReader $reader) : ?Block{
		return null;
	}

}