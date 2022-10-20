<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{Block, Opaque};
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\data\runtime\{RuntimeDataReader, RuntimeDataWriter};
use pocketmine\math\{Vector3, Facing};
use pocketmine\item\{Item};
use pocketmine\player\Player;
use pocketmine\world\{BlockTransaction};

class Dropper extends Opaque{
	use AnyFacingTrait;

	public bool $triggeredBit = false;

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

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			if(
				abs($player->getPosition()->getX() - $this->position->getX()) < 2 &&
				abs($player->getPosition()->getZ() - $this->position->getZ()) < 2
			){
				$y = $player->getEyePos()->getY();

				if($y - $this->position->getY() > 2){
					$this->facing = Facing::UP;
				}elseif($this->position->getY() - $y > 0){
					$this->facing = Facing::DOWN;
				}else{
					$this->facing = Facing::opposite($player->getHorizontalFacing());
				}
			}else{
				$this->facing = Facing::opposite($player->getHorizontalFacing());
			}
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

}