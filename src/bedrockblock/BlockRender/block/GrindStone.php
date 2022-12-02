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

class GrindStone extends Opaque implements IBlockState{
	use BlockTypeIdTrait;
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	public const ATTACHMENT_STANDING = 'standing';
	public const ATTACHMENT_HANGING = 'hanging';
	public const ATTACHMENT_SIDE = 'side';
	public const ATTACHMENT_MULTIPLE = 'multiple';


	private string $attachment = self::ATTACHMENT_STANDING;

	public function getRequiredStateDataBits() : int{ return 2; }

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->horizontalFacing($this->facing);
	}

	public function getAttachment() : string{
		return $this->attachment;
	}

	public function setAttachment(string $attachment) : self{
		$this->attachment = $attachment;
		return $this;
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::GRINDSTONE)
			->writeLegacyHorizontalFacing($this->facing)
			->writeString(BlockStateNames::ATTACHMENT, $this->attachment);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)
			->setFacing($reader->readLegacyHorizontalFacing())
			->setAttachment($reader->readString(BlockStateNames::ATTACHMENT));
	}

}