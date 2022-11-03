<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\block\Block;

interface IBlockState{

	public static function TYPE_ID() : int;

	public function encode() : BlockStateWriter;

	/** @phpstan-return Block */
	public function decode(BlockStateReader $reader) : self;

}