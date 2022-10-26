<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;

class Conduit extends Flowable implements IBlockState{
	use NoneStateTrait;
}