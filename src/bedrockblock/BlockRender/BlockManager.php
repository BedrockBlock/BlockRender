<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\VanillaBlocks;
use bedrockblock\BlockRender\block\{
	AmethystCluster,
	AzaleaLeaves,
	AzaleaLeavesFlowered,
	BeeNest,
	Beehive,
	BigDripleaf,
	BorderBlock,
	BubbleColumn,
	Campfire,
	CaveVines,
	CaveVinesHeadWithBerries,
	Chain,
	CaveVinesBodyWithBerries,
	ChainCommandBlock,
	CommandBlock,
	Dispenser,
	Dropper,
	Piston,
	PistonArmCollision,
	RepeatingCommandBlock,
	SculkShrieker,
	SeaGrass,
	SoulCampfire
};

use pocketmine\block\{
	Block,
	BlockFactory,
	VanillaBlocks as Blocks,
	BlockTypeInfo as Info,
	BlockBreakInfo as BreakInfo,
	BlockIdentifier as BID,
	BlockToolType as ToolType,
	Wall
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
	BlockStateToObjectDeserializer,
	BlockStateSerializerHelper as SerializerHelper,
	BlockStateDeserializerHelper as DeserializerHelper
};
use pocketmine\item\StringToItemParser;
use pocketmine\world\format\io\GlobalBlockStateHandlers;

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
			VanillaBlocks::BEE_NEST(),
			static function(BeeNest $block) : Writer{
				return Writer::create(TypeNames::BEE_NEST)
					->writeLegacyHorizontalFacing($block->getFacing())
					->writeInt(StateNames::HONEY_LEVEL, $block->getHoneyLevel());
			},
			static function(Reader $in) : BeeNest{
				return VanillaBlocks::BEE_NEST()
					->setFacing($in->readLegacyHorizontalFacing())
					->setHoneyLevel($in->readInt(StateNames::HONEY_LEVEL));
			}
		);
		self::register(
			VanillaBlocks::BEEHIVE(),
			static function(Beehive $block) : Writer{
				return Writer::create(TypeNames::BEEHIVE)
					->writeLegacyHorizontalFacing($block->getFacing())
					->writeInt(StateNames::HONEY_LEVEL, $block->getHoneyLevel());
			},
			static function(Reader $in) : Beehive{
				return VanillaBlocks::BEEHIVE()
					->setFacing($in->readLegacyHorizontalFacing())
					->setHoneyLevel($in->readInt(StateNames::HONEY_LEVEL));
			}
		);
		self::register(
			VanillaBlocks::BIG_DRIPLEAF(),
			static function(BigDripleaf $block) : Writer{
				return Writer::create(TypeNames::BIG_DRIPLEAF)
					->writeLegacyHorizontalFacing($block->getFacing())
					->writeBool(StateNames::BIG_DRIPLEAF_HEAD, $block->isHead())
					->writeString(StateNames::BIG_DRIPLEAF_TILT, $block->getTilt());
			},
			static function(Reader $in) : BigDripleaf{
				return VanillaBlocks::BIG_DRIPLEAF()
					->setFacing($in->readLegacyHorizontalFacing())
					->setHead($in->readBool(StateNames::BIG_DRIPLEAF_HEAD))
					->setTilt($in->readString(StateNames::BIG_DRIPLEAF_TILT));
			}
		);
		self::register(
			VanillaBlocks::BORDER_BLOCK(), 
			static fn(BorderBlock $block) : Writer => SerializerHelper::encodeWall($block, new Writer(TypeNames::BORDER_BLOCK)),
			static fn(Reader $in) : BorderBlock => DeserializerHelper::decodeWall(VanillaBlocks::BORDER_BLOCK(), $in)
		);
		self::register(
			VanillaBlocks::BUBBLE_COLUMN(),
			static fn(BubbleColumn $block) : Wrter => Writer::create(TypeNames::BUBBLE_COLUMN)->writeBool(StateNames::DRAG_DOWN, $block->isDragDown()),
			static fn(Reader $in) : BubbleColumn => VanillaBlocks::BUBBLE_COLUMN()->setDragDown($in->readBool(StateNames::DRAG_DOWN))
		);
		self::register(
			VanillaBlocks::CAMPFIRE(),
			static function(Campfire $block) : Writer{
				return Writer::create(TypeNames::CAMPFIRE)
					->writeLegacyHorizontalFacing($block->getFacing())
					->writeBool(StateNames::EXTINGUISHED, $block->isExtinguished());
			},
			static function(Reader $in) : Campfire{
				return VanillaBlocks::CAMPFIRE()
					->setFacing($in->readLegacyHorizontalFacing())
					->setExtinguished($in->readBool(StateNames::EXTINGUISHED));
			}
		);
		self::register(
			VanillaBlocks::CAVE_VINES(),
			static fn(CaveVines $block) : Writer => Writer::create(TypeNames::CAVE_VINES)->writeInt(StateNames::GROWING_PLANT_AGE, $block->getAge()),
			static fn(Reader $in) : CaveVines => VanillaBlocks::CAVE_VINES()->setAge($in->readInt(StateNames::GROWING_PLANT_AGE))
		);
		self::register(
			VanillaBlocks::CAVE_VINES_HEAD_WITH_BERRIES(),
			static fn(CaveVinesHeadWithBerries $block) : Writer => Writer::create(TypeNames::CAVE_VINES_HEAD_WITH_BERRIES)->writeInt(StateNames::GROWING_PLANT_AGE, $block->getAge()),
			static fn(Reader $in) : CaveVinesHeadWithBerries => VanillaBlocks::CAVE_VINES_HEAD_WITH_BERRIES()->setAge($in->readInt(StateNames::GROWING_PLANT_AGE))
		);
		self::register(
			VanillaBlocks::CHAIN(), 
			static fn(Chain $block) => Writer::create(TypeNames::CHAIN)
				->writePillarAxis($block->getAxis()),
			static function(Reader $in) : Chain{
				return VanillaBlocks::CHAIN()
					->setAxis($in->readPillarAxis());
			},
			true
		);
		self::register(
			VanillaBlocks::CAVE_VINES_BODY_WITH_BERRIES(),
			static fn(CaveVinesBodyWithBerries $block) : Writer => Writer::create(TypeNames::CAVE_VINES_BODY_WITH_BERRIES)->writeInt(StateNames::GROWING_PLANT_AGE, $block->getAge()),
			static fn(Reader $in) : CaveVinesBodyWithBerries => VanillaBlocks::CAVE_VINES_BODY_WITH_BERRIES()->setAge($in->readInt(StateNames::GROWING_PLANT_AGE))
		);
		self::register(
			VanillaBlocks::CHAIN_COMMAND_BLOCK(),
			static function(ChainCommandBlock $block) : Writer{
				return Writer::create(TypeNames::CHAIN_COMMAND_BLOCK)
					->writeFacingDirection($block->getFacing())
					->writeBool(StateNames::CONDITIONAL_BIT, $block->isConditional());
			},
			static function(Reader $in) : ChainCommandBlock{
				return VanillaBlocks::CHAIN_COMMAND_BLOCK()
					->setFacing($in->readFacingDirection())
					->setConditional($in->readBool(StateNames::CONDITIONAL_BIT));
			}
		);
		self::register(
			VanillaBlocks::COMMAND_BLOCK(),
			static function(CommandBlock $block) : Writer{
				return Writer::create(TypeNames::COMMAND_BLOCK)
					->writeFacingDirection($block->getFacing())
					->writeBool(StateNames::CONDITIONAL_BIT, $block->isConditional());
			},
			static function(Reader $in) : CommandBlock{
				return VanillaBlocks::COMMAND_BLOCK()
					->setFacing($in->readFacingDirection())
					->setConditional($in->readBool(StateNames::CONDITIONAL_BIT));
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
			VanillaBlocks::REPEATING_COMMAND_BLOCK(),
			static function(RepeatingCommandBlock $block) : Writer{
				return Writer::create(TypeNames::REPEATING_COMMAND_BLOCK)
					->writeFacingDirection($block->getFacing())
					->writeBool(StateNames::CONDITIONAL_BIT, $block->isConditional());
			},
			static function(Reader $in) : RepeatingCommandBlock{
				return VanillaBlocks::REPEATING_COMMAND_BLOCK()
					->setFacing($in->readFacingDirection())
					->setConditional($in->readBool(StateNames::CONDITIONAL_BIT));
			}
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
		self::register(
			VanillaBlocks::SOUL_CAMPFIRE(),
			static function(SoulCampfire $block) : Writer{
				return Writer::create(TypeNames::SOUL_CAMPFIRE)
					->writeLegacyHorizontalFacing($block->getFacing())
					->writeBool(StateNames::EXTINGUISHED, $block->isExtinguished());
			},
			static function(Reader $in) : SoulCampfire{
				return VanillaBlocks::SOUL_CAMPFIRE()
					->setFacing($in->readLegacyHorizontalFacing())
					->setExtinguished($in->readBool(StateNames::EXTINGUISHED));
			}
		);
	}

	private static function registerSimples() : void{
		self::register(VanillaBlocks::ALLOW());
		self::register(VanillaBlocks::AZALEA());
		self::register(VanillaBlocks::BUDDING_AMETHYST());
		self::register(VanillaBlocks::CAMERA());
		self::register(VanillaBlocks::CLIENT_REQUEST_PLACEHOLDER_BLOCK());
		self::register(VanillaBlocks::CRIMSON_FUNGUS());
		self::register(VanillaBlocks::DENY());
		self::register(VanillaBlocks::END_GATEWAY());
		self::register(VanillaBlocks::MOSS_CARPET());
		self::register(VanillaBlocks::POWDER_SNOW());
		self::register(VanillaBlocks::REINFORCED_DEEPSLATE());
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
		?Closure $deserializeCallback = null,
		bool $notAddItemParser = false
	) : void{
		$name = strtolower(str_replace(' ', '_', $block->getName()));
		$namespace = 'minecraft:' . $name;

		GlobalBlockStateHandlers::getSerializer()->map($block, $serializeCallback ?? static fn() : Writer => Writer::create($namespace));
		GlobalBlockStateHandlers::getDeserializer()->map($namespace, $deserializeCallback ?? static fn() : Block => clone $block);

		if(!$notAddItemParser) StringToItemParser::getInstance()->registerBlock($name, fn() => clone $block);

		try{
			BlockFactory::getInstance()->register($block);
		}catch(\InvalidArgumentException $e){
			//NOOP
		}
	}
}