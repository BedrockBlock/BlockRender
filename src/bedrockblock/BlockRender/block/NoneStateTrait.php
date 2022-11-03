<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};

use function str_replace;
use function strtolower;

/** @see IBlockState */
trait NoneStateTrait{
	use BlockTypeIdTrait;

	public function encode() : BlockStateWriter{
		$namespace = 'minecraft:' . strtolower(str_replace(' ', '_', $this->getName()));
		return BlockStateWriter::create($namespace);
	}

	public function decode(BlockStateReader $reader) : self{
		return clone $this;
	}

}