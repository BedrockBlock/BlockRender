<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\Flowable;
use pocketmine\data\runtime\{
	RuntimeDataReader,
	RuntimeDataWriter
};

class SeaGrass extends Flowable{

	public const DEFAULT = 'default';
	public const DOUBLE_TOP = 'double_top';
	public const DOUBLE_BOT = 'double_bot';

	private string $type = self::DEFAULT;

	public function getType() : string{
		return $this->type;
	}

	public function setType(string $type) : self{
		$this->type = $type;
		return $this;
	}

}