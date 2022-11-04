<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SeaGrass extends Flowable implements IBlockState{
	use BlockTypeIdTrait;

	public const DEFAULT = 'default';
	public const DOUBLE_TOP = 'double_top';
	public const DOUBLE_BOT = 'double_bot';

	private string $type = self::DEFAULT;

	public function getType() : string{
		return $this->type;
	}

	public function setType(string $type) : self{
		$this->type = $type;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::SEAGRASS)->writeString(BlockStateNames::SEA_GRASS_TYPE, $this->type);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setType($reader->readString(BlockStateNames::SEA_GRASS_TYPE));
	}

}