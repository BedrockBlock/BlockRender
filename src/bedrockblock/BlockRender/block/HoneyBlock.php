<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;

class HoneyBlock extends Opaque implements IBlockState{
	use NoneStateTrait;
}