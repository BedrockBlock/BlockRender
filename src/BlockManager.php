<?php

declare(strict_types=1);

namespace bedrockblock\BlockRender;

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
use pocketmine\utils\SingletonTrait;
use pocketmine\world\format\io\GlobalBlockStateHandlers;
use pocketmine\item\StringToItemParser;

use Closure;

use function str_replace;
use function strtolower;

final class BlockManager{
	use SingletonTrait;

	private BlockFactory $blockFactory;

	private BlockObjectToStateSerializer $serializer;
	private BlockStateToObjectDeserializer $deserializer;

	private StringToItemParser $itemParser;

	public function __construct(){
		self::setInstance($this);
		$this->blockFactory = BlockFactory::getInstance();
		$this->serializer = GlobalBlockStateHandlers::getSerializer();
		$this->deserializer = GlobalBlockStateHandlers::getDeserializer();
		$this->itemParser = StringToItemParser::getInstance();
		$this->init();
	}

	private function init() : void{
		
	}

	public function register(
		Block $block,
		bool $registerItemParserName = true,
		?Closure $serializeCallback = null,
		?Closure $deserializeCallback = null
	){
		$name = strtolower(str_replace(' ', '_', $block->getName()));
		$namespace = 'minecraft:' . $name;

		$this->serializer->map($block, $serializeCallback ?? fn() => Writer::create($namespace));
		$this->deserializer->map($namespace, $deserializeCallback ?? fn() => clone $block);

		if($registerItemParserName){
			$this->itemParser->registerBlock($name, fn() => clone $block);
			$this->itemParser->registerBlock($namespace, fn() => clone $block);
		}

		$blockFactory->register($block, false);
	}

}