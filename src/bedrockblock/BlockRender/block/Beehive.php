<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;
use pocketmine\data\bedrock\block\{
	BlockStateNames,
	BlockTypeNames
};
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\block\utils\{
	FacesOppositePlacingPlayerTrait,
	HorizontalFacingTrait
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Beehive extends Opaque implements IBlockState{
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;
	use BlockTypeIdTrait;

	private int $honey_level = 0;

	public function getRequiredStateDataBits() : int{ return 8; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->horizontalFacing($this->facing);
		$w->int(6, $this->honey_level);
	}

	public function getHoneyLevel() : int{
		return $this->honey_level;
	}

	public function setHoneyLevel(int $level) : self{
		$this->honey_level = $level;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::BEEHIVE)
			->writeLegacyHorizontalFacing($this->facing)
			->writeInt(BlockStateNames::HONEY_LEVEL, $this->honey_level);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setFacing($reader->readLegacyHorizontalFacing())
			->setHoneyLevel($reader->readInt(BlockStateNames::HONEY_LEVEL));
	}

}