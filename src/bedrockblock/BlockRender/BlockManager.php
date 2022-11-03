<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\{
	IBlockState,
	VanillaBlocks
};

use pocketmine\block\{
	Block,
	BlockFactory,
};
use pocketmine\data\bedrock\block\convert\{
	BlockStateReader,
	BlockStateWriter,
	BlockStateSerializerHelper,
	BlockStateDeserializerHelper
};
use pocketmine\item\StringToItemParser;
use pocketmine\world\format\io\GlobalBlockStateHandlers;

use Closure;

final class BlockManager{

	private function __construct(){
		//NOOP
	}

	public static function init() : void{
		self::registerSimples();
		self::register(VanillaBlocks::ALLOW());
		self::register(VanillaBlocks::AMETHYST_CLUSTER());
		self::register(VanillaBlocks::AZALEA());
		self::register(VanillaBlocks::AZALEA_LEAVES());
		self::register(VanillaBlocks::AZALEA_LEAVES_FLOWERED());
		self::register(VanillaBlocks::BEEHIVE());
		self::register(VanillaBlocks::BEE_NEST());
		self::register(VanillaBlocks::BIG_DRIPLEAF());
		self::register(VanillaBlocks::BORDER_BLOCK());
		self::register(VanillaBlocks::BUBBLE_COLUMN());
		self::register(VanillaBlocks::CAMPFIRE(), false);
		self::register(VanillaBlocks::CAVE_VINES());
		self::register(VanillaBlocks::CAVE_VINES_BODY_WITH_BERRIES());
		self::register(VanillaBlocks::CAVE_VINES_HEAD_WITH_BERRIES());
		self::register(VanillaBlocks::CHAIN(), false);
		self::register(VanillaBlocks::CHAIN_COMMAND_BLOCK());
		self::register(VanillaBlocks::COMMAND_BLOCK());
		self::register(VanillaBlocks::COMPOSTER());
		self::register(VanillaBlocks::DISPENSER());
		self::register(VanillaBlocks::DROPPER());

		/*
		self::register(
			VanillaBlocks::PISTON(),
			static fn(Piston $block) : BlockStateWriter => BlockStateWriter::create(BlockTypeNames::PISTON)->writeFacingDirection($block->getFacing()),
			static fn(BlockStateReader $in) : Piston => VanillaBlocks::PISTON()->setFacing($in->readFacingDirection())
		);
		self::register(
			VanillaBlocks::PISTON_ARM_COLLISION(),
			static fn(PistonArmCollision $block) : BlockStateWriter => BlockStateWriter::create(BlockTypeNames::PISTON_ARM_COLLISION)->writeFacingDirection($block->getFacing()),
			static fn(BlockStateReader $in) : PistonArmCollision => VanillaBlocks::PISTON_ARM_COLLISION()->setFacing($in->readFacingDirection())
		);
		self::register(
			VanillaBlocks::REPEATING_COMMAND_BLOCK(),
			static function(RepeatingCommandBlock $block) : BlockStateWriter{
				return BlockStateWriter::create(BlockTypeNames::REPEATING_COMMAND_BLOCK)
					->writeFacingDirection($block->getFacing())
					->writeBool(BlockStateNames::CONDITIONAL_BIT, $block->isConditional());
			},
			static function(BlockStateReader $in) : RepeatingCommandBlock{
				return VanillaBlocks::REPEATING_COMMAND_BLOCK()
					->setFacing($in->readFacingDirection())
					->setConditional($in->readBool(BlockStateNames::CONDITIONAL_BIT));
			}
		);
		self::register(
			VanillaBlocks::KELP(),
			static function(Kelp $block) : BlockStateWriter{
				return BlockStateWriter::create(BlockTypeNames::KELP)
					->writeInt(BlockStateNames::KELP_AGE, $block->getKelpAge());
			},
			static function(BlockStateReader $in) : Kelp{
				return VanillaBlocks::KELP()
					->setKelpAge($in->readInt(BlockStateNames::KELP_AGE));
			},
			false
		);
		self::register(
			VanillaBlocks::SCULK_CATALYST(),
			static function(SculkCatalyst $block) : BlockStateWriter{
				return BlockStateWriter::create(BlockTypeNames::SCULK_CATALYST)
					->writeBool(BlockStateNames::BLOOM, $block->isBloom());
			},
			static function(BlockStateReader $in) : SculkCatalyst{
				return VanillaBlocks::SCULK_CATALYST()
					->setBloom($in->readBool(BlockStateNames::BLOOM));
			}
		);
		self::register(
			VanillaBlocks::SCULK_SENSOR(),
			static function(SculkSensor $block) : BlockStateWriter{
				return BlockStateWriter::create(BlockTypeNames::SCULK_SENSOR)
					->writeBool(BlockStateNames::POWERED_BIT, $block->isPoweredBit());
			},
			static function(BlockStateReader $in) : SculkSensor{
				return VanillaBlocks::SCULK_SENSOR()
					->setPoweredBit($in->readBool(BlockStateNames::POWERED_BIT));
			}
		);
		self::register(
			VanillaBlocks::SCULK_SHRIEKER(),
			static function(SculkShrieker $block) : BlockStateWriter{
				return BlockStateWriter::create(BlockTypeNames::SCULK_SHRIEKER)
					->writeBool(BlockStateNames::ACTIVE, $block->isActive())
					->writeBool(BlockStateNames::CAN_SUMMON, $block->canSummon());
			},
			static function(BlockStateReader $in) : SculkShrieker{
				return VanillaBlocks::SCULK_SHRIEKER()
					->setActive($in->readBool(BlockStateNames::ACTIVE))
					->setSummon($in->readBool(BlockStateNames::CAN_SUMMON));
			}
		);
		self::register(
			VanillaBlocks::SEAGRASS(),
			static fn(SeaGrass $block) : BlockStateWriter => BlockStateWriter::create(BlockTypeNames::SEAGRASS)->writeString(BlockStateNames::SEA_GRASS_TYPE, $block->getType()),
			static fn(BlockStateReader $in) : SeaGrass => VanillaBlocks::SEAGRASS()->setType($in->readString(BlockStateNames::SEA_GRASS_TYPE))
		);
		self::register(
			VanillaBlocks::SOUL_CAMPFIRE(),
			static function(SoulCampfire $block) : BlockStateWriter{
				return BlockStateWriter::create(BlockTypeNames::SOUL_CAMPFIRE)
					->writeLegacyHorizontalFacing($block->getFacing())
					->writeBool(BlockStateNames::EXTINGUISHED, $block->isExtinguished());
			},
			static function(BlockStateReader $in) : SoulCampfire{
				return VanillaBlocks::SOUL_CAMPFIRE()
					->setFacing($in->readLegacyHorizontalFacing())
					->setExtinguished($in->readBool(BlockStateNames::EXTINGUISHED));
			},
			false
		);*/
	}

	private static function registerSimples() : void{
		self::register(VanillaBlocks::BUDDING_AMETHYST());
		self::register(VanillaBlocks::CAMERA());
		self::register(VanillaBlocks::CLIENT_REQUEST_PLACEHOLDER_BLOCK());
		self::register(VanillaBlocks::CONDUIT());
		self::register(VanillaBlocks::CRIMSON_FUNGUS());
		self::register(VanillaBlocks::CRIMSON_NYLIUM());
		self::register(VanillaBlocks::CRIMSON_ROOTS());
		self::register(VanillaBlocks::DENY());
		self::register(VanillaBlocks::DRIPSTONE_BLOCK());
		self::register(VanillaBlocks::END_GATEWAY());
		self::register(VanillaBlocks::END_PORTAL());
		self::register(VanillaBlocks::FLOWERING_AZALEA());
		self::register(VanillaBlocks::FROG_SPAWN());
		self::register(VanillaBlocks::MOSS_CARPET());
		self::register(VanillaBlocks::POWDER_SNOW());
		self::register(VanillaBlocks::REINFORCED_DEEPSLATE());
		self::register(VanillaBlocks::SCULK());
		self::register(VanillaBlocks::WARPED_FUNGUS());
		self::register(VanillaBlocks::WARPED_NYLIUM());
		self::register(VanillaBlocks::WARPED_ROOTS());
	}

	public static function register(Block&IBlockState $block, bool $addItemParser = true) : void{
		$name = strtolower(str_replace(' ', '_', $block->getName()));
		$namespace = 'minecraft:' . $name;

		GlobalBlockStateHandlers::getSerializer()->map($block, static fn(Block $b) : BlockStateWriter => $b->encode());
		GlobalBlockStateHandlers::getDeserializer()->map($namespace, static fn(BlockStateReader $reader) : Block => $block->decode($reader));

		if($addItemParser){
			StringToItemParser::getInstance()->registerBlock($name, static fn() => clone $block);
		}

		BlockFactory::getInstance()->register($block);
	}
}