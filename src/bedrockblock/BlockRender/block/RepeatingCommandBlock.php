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

class RepeatingCommandBlock extends Opaque implements IBlockState{
	use BlockTypeIdTrait;
	use PlayerYFacingTrait;

	private bool $conditional = false;

	public function getRequiredStateDataBits() : int{ return 4; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
		$w->bool($this->conditional);
	}

	public function isConditional() : bool{
		return $this->conditional;
	}

	public function setConditional(bool $conditional) : self{
		$this->conditional = $conditional;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::REPEATING_COMMAND_BLOCK)
			->writeFacingDirection($this->facing)
			->writeBool(BlockStateNames::CONDITIONAL_BIT, $this->conditional);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setFacing($reader->readFacingDirection())
			->setConditional($reader->readBool(BlockStateNames::CONDITIONAL_BIT));
	}

}