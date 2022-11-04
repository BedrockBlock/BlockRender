<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\data\bedrock\block\BlockStateNames;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SculkShrieker extends Opaque implements IBlockState{
	use BlockTypeIdTrait;

	private bool $isActive = false;

	private bool $canSummon = false;

	public function getRequiredStateDataBits() : int{ return 2; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->bool($this->isActive);
		$w->bool($this->canSummon);
	}

	public function isActive() : bool{
		return $this->isActive;
	}

	public function setActive(bool $active) : self{
		$this->isActive = $active;
		return $this;
	}

	public function canSummon() : bool{
		return $this->canSummon;
	}

	public function setSummon(bool $summon) : self{
		$this->canSummon = $summon;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::SCULK_SHRIEKER)
			->writeBool(BlockStateNames::ACTIVE, $this->isActive)
			->writeBool(BlockStateNames::CAN_SUMMON, $this->canSummon);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setActive($reader->readBool(BlockStateNames::ACTIVE))
			->setSummon($reader->readBool(BlockStateNames::CAN_SUMMON));
	}

}