<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender\block;

use pocketmine\block\{
	Block,
	BlockTypeIds,
	BlockBreakInfo as BreakInfo,
	BlockIdentifier as BID,
	BlockTypeInfo as Info
};
use pocketmine\utils\CloningRegistryTrait;

/**
 * @method static Dropper DROPPER()
 */
final class VanillaBlocks{
	use CloningRegistryTrait;

	private function __construct(){
		//NOOP
	}

	protected static function register(string $name, Block $block) : void{
		self::_registryRegister($name, $block);
	}

	/**
	 * @return Block[]
	 * @phpstan-return array<string, Block>
	 */
	public static function getAll() : array{
		/** @var Block[] $result */
		$result = self::_registryGetAll();
		return $result;
	}

	protected static function setup() : void{
		self::register('dropper', new Dropper(
			new BID(BlockTypeIds::newId()),
			'Dropper',
			new Info(BreakInfo::pickaxe(3.5))
		));
	}

}