<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\VanillaBlocks;
use bedrockblock\BlockRender\block\{
	AmethystCluster,
	AzaleaLeaves,
	AzaleaLeavesFlowered,
	Dispenser,
	Dropper,
	Piston,
	PistonArmCollision,
	SculkShrieker,
	SeaGrass
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
		self::registerSimples();

		self::register(
			VanillaBlocks::AMETHYST_CLUSTER(),
			static fn(AmethystCluster $block) : Writer => Writer::create(TypeNames::AMETHYST_CLUSTER)->writeFacingDirection($block->getFacing()),
			static fn(Reader $in) : AmethystCluster => VanillaBlocks::AMETHYST_CLUSTER()->setFacing($in->readFacingDirection())
		);
		self::register(
			VanillaBlocks::AZALEA_LEAVES(),
			static function(AzaleaLeaves $block) : Writer{
				return Writer::create(TypeNames::AZALEA_LEAVES)
					->writeBool(StateNames::PERSISTENT_BIT, $block->isPersistentBit())
					->writeBool(StateNames::UPDATE_BIT, $block->isUpdateBit());
			},
			static function(Reader $in) : AzaleaLeaves{
				return VanillaBlocks::AZALEA_LEAVES()
					->setPersistentBit($in->readBool(StateNames::PERSISTENT_BIT))
					->setUpdateBit($in->readBool(StateNames::UPDATE_BIT));
			}
		);
		self::register(
			VanillaBlocks::AZALEA_LEAVES_FLOWERED(),
			static function(AzaleaLeavesFlowered $block) : Writer{
				return Writer::create(TypeNames::AZALEA_LEAVES_FLOWERED)
					->writeBool(StateNames::PERSISTENT_BIT, $block->isPersistentBit())
					->writeBool(StateNames::UPDATE_BIT, $block->isUpdateBit());
			},
			static function(Reader $in) : AzaleaLeavesFlowered{
				return VanillaBlocks::AZALEA_LEAVES_FLOWERED()
					->setPersistentBit($in->readBool(StateNames::PERSISTENT_BIT))
					->setUpdateBit($in->readBool(StateNames::UPDATE_BIT));
			}
		);
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
		self::register(
			VanillaBlocks::SCULK_SHRIEKER(),
			static function(SculkShrieker $block) : Writer{
				return Writer::create(TypeNames::SCULK_SHRIEKER)
					->writeBool(StateNames::ACTIVE, $block->isActive())
					->writeBool(StateNames::CAN_SUMMON, $block->canSummon());
			},
			static function(Reader $in) : SculkShrieker{
				return VanillaBlocks::SCULK_SHRIEKER()
					->setActive($in->readBool(StateNames::ACTIVE))
					->setSummon($in->readBool(StateNames::CAN_SUMMON));
			}
		);
		self::register(
			VanillaBlocks::SEAGRASS(),
			static fn(SeaGrass $block) : Writer => Writer::create(TypeNames::SEAGRASS)->writeString(StateNames::SEA_GRASS_TYPE, $block->getType()),
			static fn(Reader $in) : SeaGrass => VanillaBlocks::SEAGRASS()->setType($in->readString(StateNames::SEA_GRASS_TYPE))
		);
	}

	private static function registerSimples() : void{
		self::register(VanillaBlocks::ALLOW());
		self::register(VanillaBlocks::AZALEA());
		self::register(VanillaBlocks::CRIMSON_FUNGUS());
		self::register(VanillaBlocks::END_GATEWAY());
		self::register(VanillaBlocks::MOSS_CARPET());
		self::register(VanillaBlocks::POWDER_SNOW());
		self::register(VanillaBlocks::WARPED_FUNGUS());
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

		try{
			BlockFactory::getInstance()->register($block);
		}catch(\InvalidArgumentException $e){
			//NOOP
		}
	}

}
