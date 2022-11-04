<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Wall;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\{BlockStateReader,
	BlockStateSerializerHelper,
	BlockStateDeserializerHelper,
	BlockStateWriter};

class BorderBlock extends Wall implements IBlockState{
	use BlockTypeIdTrait;

	public function encode() : BlockStateWriter{
		return BlockStateSerializerHelper::encodeWall($this, new BlockStateWriter(BlockTypeNames::BORDER_BLOCK));
	}


	/** @phpstan-return Wall */
	public function decode(BlockStateReader $reader) : self{
		return BlockStateDeserializerHelper::decodeWall(clone $this, $reader);
	}

}