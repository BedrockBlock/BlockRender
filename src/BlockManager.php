<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\{
	Dropper,
	VanillaBlocks
};

use pocketmine\block\{
	Block,
	BlockFactory,
	VanillaBlocks as Blocks,
	BlockTypeInfo as Info, 
	BlockBreakInfo as BreakInfo,
	BlockIdentifier as BID, 
	BlockToolType as ToolType
};
use pocketmine\data\bedrock\block\{
	BlockStateNames as StateNames,
	BlockTypeNames as TypeNames,
	BlockStateSerializeException
};
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader as Reader,
	BlockStateWriter as Writer,
	BlockObjectToStateSerializer,
	BlockStateToObjectDeserializer
};
use pocketmine\world\format\io\GlobalBlockStateHandlers;
use pocketmine\item\StringToItemParser;
use pocketmine\utils\Utils;

use Closure;

use function str_replace;
use function strtolower;

final class BlockManager{

	private function __construct(){
		//NOOP
	}

	public static function init() : void{
		self::register(
			block: VanillaBlocks::DROPPER(),
			serializeCallback: function(Dropper $block) : Writer{
				return Writer::create(TypeNames::DROPPER)
					->writeFacingDirection($block->getFacing())
					->writeBool(StateNames::TRIGGERED_BIT, $block->isTriggeredBit());
			},
			deserializeCallback: function(Reader $in) : Dropper{
				return VanillaBlocks::DROPPER()
					->setFacing($in->readFacingDirection())
					->setTriggeredBit($in->readBool(StateNames::TRIGGERED_BIT));
			}
		);
	}

	/**
	 * @phpstan-template TBlockType of Block
	 * @phpstan-param TBlockType $block
	 * @phpstan-param null|Closure(TBlockType) : Writer $serializeCallback
	 * @phpstan-param null|Closure(Readerr) : TBlockType $deserializeCallback
	 */
	public static function register(
		Block $block,
		bool $registerItemParserName = true,
		?Closure $serializeCallback = null,
		?Closure $deserializeCallback = null
	) : void{
		$name = strtolower(str_replace(' ', '_', $block->getName()));
		$namespace = 'minecraft:' . $name;

		GlobalBlockStateHandlers::getSerializer()->map($block, $serializeCallback ?? static fn() : Writer => Writer::create($namespace));
		GlobalBlockStateHandlers::getDeserializer()->map($namespace, $deserializeCallback ?? static fn() : Block=> clone $block);

		if($registerItemParserName){
			StringToItemParser::getInstance()->registerBlock($name, fn() => clone $block);
		}

		BlockFactory::getInstance()->register($block, false);
	}

}