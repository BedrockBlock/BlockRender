<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
}
use pocketmine\block\Block;

interface RenderBlock{

	public static function TYPE_ID() : int;

	public static function BLOCK() : Block;

	public function encode(Block $block) : BlockStateWriter;

	public static function decode(BlockStateReader $reader) : Block;

}