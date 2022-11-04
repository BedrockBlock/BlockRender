<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\VanillaBlocks;
use bedrockblock\BlockRender\item\VanillaItems;

use pocketmine\block\Block;
use pocketmine\data\bedrock\item\SavedItemData as Data;
use pocketmine\item\{
	Item,
	StringToItemParser
};
use pocketmine\world\format\io\GlobalItemDataHandlers;

use Closure;

use function str_replace;
use function strtolower;

final class ItemManager{

	private function __construct(){
		//NOOP
	}

	public static function init() : void{
		self::registerSimples();
		self::registerItemBlock();
	}

	private static function registerSimples() : void{
		//self::register(VanillaItems::CHAIN(), null, null); sample
	}

	private static function registerItemBlock() : void{
		self::registerBlock(VanillaBlocks::CAMPFIRE());
		self::registerBlock(VanillaBlocks::CHAIN());
		self::registerBlock(VanillaBlocks::KELP());
		self::registerBlock(VanillaBlocks::SOUL_CAMPFIRE());
	}

	/**
	 * @phpstan-template TItemType of item
	 * @phpstan-param TItemType $item
	 * @phpstan-param null|Closure(TItemType) : Data $serializeCallback
	 * @phpstan-param null|Closure(Data) : Item $deserializeCallback
	 */
	public static function register(
		Item $item,
		?Closure $serializeCallback = null,
		?Closure $deserializeCallback = null
	) : void{
		$name = strtolower(str_replace(' ', '_', $item->getName()));
		$namespace = 'minecraft:'.$name;

		GlobalItemDataHandlers::getSerializer()->map($item, $serializeCallback ?? static fn() => new Data($namespace));
		GlobalItemDataHandlers::getDeserializer()->map($namespace, $deserializeCallback ?? static fn() => clone $item);

		StringToItemParser::getInstance()->register($name, fn() => clone $item);
	}

	/**
	 * @phpstan-template TBlockType of Block
	 * @phpstan-param TBlockType $block
	 * @phpstan-param null|Closure(TBlockType) : Data $serializeCallback
	 * @phpstan-param null|Closure(Data) : Block $deserializeCallback
	 */
	public static function registerBlock(
		Block $block,
		?Closure $serializeCallback = null,
		?Closure $deserializeCallback = null
	) : void{
		$name = strtolower(str_replace(' ', '_', $block->asItem()->getName()));
		$namespace = 'minecraft:'.$name;

		GlobalItemDataHandlers::getSerializer()->mapBlock($block, $serializeCallback ?? fn() => new Data($namespace));
		GlobalItemDataHandlers::getDeserializer()->mapBlock($namespace, $deserializeCallback ?? fn() => $block);

		StringToItemParser::getInstance()->registerBlock($name, fn() => clone $block);
	}
}
