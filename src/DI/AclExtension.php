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
	public $defaults = [
		'guest' => ['allow' => [], 'parent' => null],
		'user' => ['allow' => [], 'parent' => 'guest'],
		'client' => ['allow' => [], 'parent' => 'user'],
		'admin' => ['allow' => [], 'parent' => 'user'],
		'superadmin' => ['allow' => [], 'parent' => 'admin'],
	];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$this->validateConfig($this->defaults);

		$config = $this->config;

		$configuration = $builder->addDefinition($this->prefix('acl'))
			->setClass('XRuff\App\Security\Acl')
			->setArguments([$config])
			->addTag(Nette\DI\Extensions\InjectExtension::TAG_INJECT);
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
