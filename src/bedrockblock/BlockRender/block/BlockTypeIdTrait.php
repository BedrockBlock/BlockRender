<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\BlockTypeIds;

trait BlockTypeIdTrait{

	/** @see IBlockState::TYPE_ID */
	public static function TYPE_ID() : int{
		static $id = null;
		if($id === null){
			$id = BlockTypeIds::newId();
		}
		return $id;
	}

}