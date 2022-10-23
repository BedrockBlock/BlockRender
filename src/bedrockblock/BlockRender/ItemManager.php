<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\item\VanillaItems;

use pocketmine\data\bedrock\item\SavedItemData as Data;
use pocketmine\item\{
	Item, 
	ItemBlock, 
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
	}

	private static function registerSimples() : void{
		self::register(VanillaItems::CHAIN());
	}

	/**
	 * @phpstan-template TItemType of item
	 * @phpstan-param TItemType $item
	 * @phpstan-param null|Closure(TItemType) : Writer $serializeCallback
	 * @phpstan-param null|Closure(Reader) : TItemType $deserializeCallback
	 */
	public static function register(
		Item $item,
		?Closure $serializeCallback = null,
		?Closure $deserializeCallback = null,
		bool $same = false
	) : void{
		$name = strtolower(str_replace(' ', '_', $item->getName()));
		$namespace = 'minecraft:';
		if($same){
			$namespace .= $name;
		}else{
			$namespace .= 'item.' . $name;
		}

		GlobalItemDataHandlers::getSerializer()->map($item, $serializeCallback ?? static fn() => new Data($namespace));
		GlobalItemDataHandlers::getDeserializer()->map($namespace, $deserializeCallback ?? static fn() => clone $item);

		StringToItemParser::getInstance()->register($name, fn() => clone $item);
	}
}
