<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Opaque;

class Deny extends Opaque implements IBlockState{
	use NoneStateTrait;
}