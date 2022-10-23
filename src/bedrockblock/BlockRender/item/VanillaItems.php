<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\item;

use bedrockblock\BlockRender\block\VanillaBlocks;

use pocketmine\item\{
	Item,
	ItemBlock
};
use pocketmine\utils\CloningRegistryTrait;

/**
 * @method staric ItemBlock CHAIN()
 */
final class VanillaItems{
	use CloningRegistryTrait;

	private function __construct(){
		//NOOP
	}

	protected static function register(string $name, Item $item) : void{
		self::_registryRegister($name, $item);
	}

	/**
	 * @return Item[]
	 * @phpstan-return array<string, Item>
	 */
	public static function getAll() : array{
		/** @var Item[] $result */
		$result = self::_registryGetAll();
		return $result;
	}

	protected static function setup() : void{
		self::register('chain', new ItemBlock(VanillaBlocks::CHAIN()));
	}
}