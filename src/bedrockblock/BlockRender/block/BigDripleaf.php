<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\block\utils\{
	FacesOppositePlacingPlayerTrait,
	HorizontalFacingTrait
};
use pocketmine\data\bedrock\block\{
	BlockStateNames,
	BlockTypeNames
};
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class BigDripleaf extends Flowable implements IBlockState{
	use BlockTypeIdTrait;
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	public const NONE_TIlT = 'none';
	public const UNSTABLE_TILT = 'unstable';
	public const PARTIAL_TILT = 'partial_tilt';
	public const FULL_TILT = 'full_tilt';

	private bool $isHead = true;

	private string $tilt = self::NONE_TIlT;

	public function getRequiredStateDataBits() : int{ return 3; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->horizontalFacing($this->facing);
		$w->bool($this->isHead);
	}

	public function isHead() : bool{
		return $this->isHead;
	}

	public function setHead(bool $head) : self{
		$this->isHead = $head;
		return $this;
	}

	public function getTilt() : string{
		return $this->tilt;
	}

	public function setTilt(string $tilt) : self{
		$this->tilt = $tilt;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::BIG_DRIPLEAF)
			->writeLegacyHorizontalFacing($this->facing)
			->writeBool(BlockStateNames::BIG_DRIPLEAF_HEAD, $this->isHead)
			->writeString(BlockStateNames::BIG_DRIPLEAF_TILT, $this->tilt);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setFacing($reader->readLegacyHorizontalFacing())
			->setHead($reader->readBool(BlockStateNames::BIG_DRIPLEAF_HEAD))
			->setTilt($reader->readString(BlockStateNames::BIG_DRIPLEAF_TILT));
	}

}