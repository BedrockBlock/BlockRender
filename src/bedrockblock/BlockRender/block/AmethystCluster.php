<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{Block, Opaque};
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter
};
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class AmethystCluster extends Opaque implements IBlockState{
	use AnyFacingTrait;
	use BlockTypeIdTrait;

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->facing = $face;
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function encode() : BlockStateWriter{
		return BlockStateWriter::create(BlockTypeNames::AMETHYST_CLUSTER)->writeFacingDirection($this->facing);
	}

	public function decode(BlockStateReader $reader) : self{
		return (clone $this)->setFacing($reader->readFacingDirection());
	}

}