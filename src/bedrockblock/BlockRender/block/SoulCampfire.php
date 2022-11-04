<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\block\utils\{
	FacesOppositePlacingPlayerTrait,
	HorizontalFacingTrait
};
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SoulCampfire extends Opaque implements IBlockState{
	use BlockTypeIdTrait;
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	private bool $extinguished = false;

	public function getRequiredStateDataBits() : int{ return 3; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->horizontalFacing($this->facing);
		$w->bool($this->extinguished);
	}

	public function isExtinguished() : bool{
		return $this->extinguished;
	}

	public function setExtinguished(bool $extinguished) : self{
		$this->extinguished = $extinguished;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::SOUL_CAMPFIRE)
			->writeFacingDirection($this->facing)
			->writeBool(BlockStateNames::EXTINGUISHED, $this->extinguished);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setFacing($reader->readFacingDirection())
			->setExtinguished($reader->readBool(BlockStateNames::EXTINGUISHED));
	}

}