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

class PistonArmCollision extends Opaque{
	use AnyFacingTrait;
	use BlockTypeIdTrait;

	protected function describeState(RuntimeDataReader|RuntimeDataWriter $w) : void{
		$w->facing($this->facing);
	}

}