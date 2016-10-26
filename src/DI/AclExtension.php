<?php

namespace XRuff\App\Security\DI;

use Nette;

/**
 * @author Pavel Lauko <info@webengine.cz>
 */
class AclExtension extends Nette\DI\CompilerExtension
{

	/**
	 * @var array
	 */
	public $defaults = [];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$config = $this->getConfig($this->defaults);

		$configuration = $builder->addDefinition($this->prefix('acl'))
			->setClass('XRuff\App\Security\Acl')
			->setArguments([$config])
			->setInject(false);
	}

	/**
	 * @param \Nette\Configurator $configurator
	 */
	public static function register(Nette\Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Nette\DI\Compiler $compiler) {
			$compiler->addExtension('acl', new AclExtension());
		};
	}

}
