<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{Block, Opaque};
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};
use pocketmine\item\Item;
use pocketmine\math\{Vector3, Facing};
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Piston extends Opaque{
	use AnyFacingTrait;

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$playerPos = $player->getPosition();
			$x = abs($playerPos->getFloorX() - $this->position->getX());
			$y = $playerPos->getFloorY() - $this->position->getY();
			$z = abs($playerPos->getFloorZ() - $this->position->getZ());
			if ($y > 0 && $x < 2 && $z < 2) {
				$this->setFacing(Facing::UP);
			} elseif ($y < -1 && $x < 2 && $z < 2) {
				$this->setFacing(Facing::DOWN);
			} else {
				$this->setFacing($player->getHorizontalFacing());
			}
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

}