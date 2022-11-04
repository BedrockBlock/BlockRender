<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use bedrockblock\BlockRender\utils\PlayerYFacingTrait;

use pocketmine\block\Opaque;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class Dispenser extends Opaque implements IBlockState{
	use PlayerYFacingTrait;
	use BlockTypeIdTrait;

	private bool $triggeredBit = false;

	public function getRequiredStateDataBits() : int{ return 4; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
		$w->bool($this->triggeredBit);
	}

	public function isTriggeredBit() : bool{
		return $this->triggeredBit;
	}

	public function setTriggeredBit(bool $triggeredBit) : self{
		$this->triggeredBit = $triggeredBit;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::DISPENSER)
			->writeFacingDirection($this->facing)
			->writeBool(BlockStateNames::TRIGGERED_BIT, $this->triggeredBit);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setFacing($reader->readFacingDirection())
			->setTriggeredBit($reader->readBool(BlockStateNames::TRIGGERED_BIT));
	}

}