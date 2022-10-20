<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\VanillaBlocks;
use bedrockblock\BlockRender\block\{
	Dispenser,
	Dropper,
	Piston,
	PistonArmCollision
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

use Closure;

use function str_replace;
use function strtolower;

final class BlockManager{

	private function __construct(){
		//NOOP
	}

	public static function init() : void{
		self::register(
			VanillaBlocks::DISPENSER(),
			static function(Dispenser $block) : Writer{
				return Writer::create(TypeNames::DISPENSER)
					->writeFacingDirection($block->getFacing())
					->writeBool(StateNames::TRIGGERED_BIT, $block->isTriggeredBit());
			},
			static function(Reader $in) : Dispenser{
				return VanillaBlocks::DISPENSER()
					->setFacing($in->readFacingDirection())
					->setTriggeredBit($in->readBool(StateNames::TRIGGERED_BIT));
			}
		);
		self::register(
			VanillaBlocks::DROPPER(),
			static function(Dropper $block) : Writer{
				return Writer::create(TypeNames::DROPPER)
					->writeFacingDirection($block->getFacing())
					->writeBool(StateNames::TRIGGERED_BIT, $block->isTriggeredBit());
			},
			static function(Reader $in) : Dropper{
				return VanillaBlocks::DROPPER()
					->setFacing($in->readFacingDirection())
					->setTriggeredBit($in->readBool(StateNames::TRIGGERED_BIT));
			}
		);
		self::register(VanillaBlocks::END_GATEWAY());
		self::register(
			VanillaBlocks::PISTON(),
			static fn(Piston $block) : Writer => Writer::create(TypeNames::PISTON)->writeFacingDirection($block->getFacing()),
			static fn(Reader $in) : Piston => VanillaBlocks::PISTON()->setFacing($in->readFacingDirection())
		);
		self::register(
			VanillaBlocks::PISTON_ARM_COLLISION(),
			static fn(PistonArmCollision $block) : Writer => Writer::create(TypeNames::PISTON_ARM_COLLISION)->writeFacingDirection($block->getFacing()),
			static fn(Reader $in) : PistonArmCollision => VanillaBlocks::PISTON_ARM_COLLISION()->setFacing($in->readFacingDirection())
		);
		self::register(VanillaBlocks::POWDER_SNOW());
	}

	/**
	 * @phpstan-template TBlockType of Block
	 * @phpstan-param TBlockType $block
	 * @phpstan-param null|Closure(TBlockType) : Writer $serializeCallback
	 * @phpstan-param null|Closure(Reader) : TBlockType $deserializeCallback
	 */
	public static function register(
		Block $block,
		?Closure $serializeCallback = null,
		?Closure $deserializeCallback = null
	) : void{
		$name = strtolower(str_replace(' ', '_', $block->getName()));
		$namespace = 'minecraft:' . $name;

		GlobalBlockStateHandlers::getSerializer()->map($block, $serializeCallback ?? static fn() : Writer => Writer::create($namespace));
		GlobalBlockStateHandlers::getDeserializer()->map($namespace, $deserializeCallback ?? static fn() : Block => clone $block);

		StringToItemParser::getInstance()->registerBlock($name, fn() => clone $block);

		BlockFactory::getInstance()->register($block, false);
	}

}