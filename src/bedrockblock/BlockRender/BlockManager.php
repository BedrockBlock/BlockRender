<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

use bedrockblock\BlockRender\block\{IBlockState, VanillaBlocks};
use pocketmine\block\{Block, BlockFactory,};
use pocketmine\data\bedrock\block\convert\{BlockStateReader, BlockStateWriter};
use pocketmine\item\StringToItemParser;
use pocketmine\world\format\io\GlobalBlockStateHandlers;

final class BlockManager{

	private function __construct(){
		//NOOP
	}

	public static function init() : void{
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
		self::register(VanillaBlocks::BUDDING_AMETHYST());
		self::register(VanillaBlocks::CAMERA());
		self::register(VanillaBlocks::CLIENT_REQUEST_PLACEHOLDER_BLOCK());
		self::register(VanillaBlocks::CAMPFIRE(), false);
		self::register(VanillaBlocks::CAVE_VINES());
		self::register(VanillaBlocks::CAVE_VINES_BODY_WITH_BERRIES());
		self::register(VanillaBlocks::CAVE_VINES_HEAD_WITH_BERRIES());
		self::register(VanillaBlocks::CHAIN(), false);
		self::register(VanillaBlocks::CHAIN_COMMAND_BLOCK());
		self::register(VanillaBlocks::COMMAND_BLOCK());
		self::register(VanillaBlocks::COMPOSTER());
		self::register(VanillaBlocks::CONDUIT());
		self::register(VanillaBlocks::CRIMSON_FUNGUS());
		self::register(VanillaBlocks::CRIMSON_NYLIUM());
		self::register(VanillaBlocks::CRIMSON_ROOTS());
		self::register(VanillaBlocks::DENY());
		self::register(VanillaBlocks::DISPENSER());
		self::register(VanillaBlocks::DRIPSTONE_BLOCK());
		self::register(VanillaBlocks::DROPPER());
		self::register(VanillaBlocks::END_GATEWAY());
		self::register(VanillaBlocks::END_PORTAL());
		self::register(VanillaBlocks::FLOWERING_AZALEA());
		self::register(VanillaBlocks::FROG_SPAWN());
		self::register(VanillaBlocks::KELP(), false);
		self::register(VanillaBlocks::MOSS_CARPET());
		self::register(VanillaBlocks::PISTON());
		self::register(VanillaBlocks::PISTON_ARM_COLLISION());
		self::register(VanillaBlocks::POWDER_SNOW());
		self::register(VanillaBlocks::REINFORCED_DEEPSLATE());
		self::register(VanillaBlocks::REPEATING_COMMAND_BLOCK());
		self::register(VanillaBlocks::SCULK());
		self::register(VanillaBlocks::SCULK_CATALYST());
		self::register(VanillaBlocks::SCULK_SENSOR());
		self::register(VanillaBlocks::SCULK_SHRIEKER());
		self::register(VanillaBlocks::SEAGRASS());
		self::register(VanillaBlocks::SOUL_CAMPFIRE(), false);
		self::register(VanillaBlocks::GRIDSTONE());
		self::register(VanillaBlocks::GLOW_LICHEN());
		self::register(VanillaBlocks::HONEY_BLOCK());
		self::register(VanillaBlocks::WARPED_FUNGUS());
		self::register(VanillaBlocks::WARPED_NYLIUM());
		self::register(VanillaBlocks::WARPED_ROOTS());
	}

	public static function register(Block&IBlockState $block, bool $addItemParser = true) : void{
		$name = strtolower(str_replace(' ', '_', $block->getName()));
		$namespace = 'minecraft:' . $name;

		GlobalBlockStateHandlers::getSerializer()->map($block,
			/** @phpstan-param Block&IBlockState $b */
			static fn(Block $b) : BlockStateWriter => $b->encode()
		);
		GlobalBlockStateHandlers::getDeserializer()->map($namespace, static fn(BlockStateReader $reader) : Block => $block->decode($reader));

		if($addItemParser){
			StringToItemParser::getInstance()->registerBlock($name, static fn() => clone $block);
		}

		BlockFactory::getInstance()->register($block);
	}
}