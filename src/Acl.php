<?php

namespace XRuff\App\Security;

use Nette\Security\Permission;

class Acl extends Permission {

	/** @var array $params */
	public $params;

	public function __construct($params) {

		$this->params = $params;

		foreach ($this->params as $roleName => $roleData) {

			if (isset($roleData['parent'])) {
				$this->addRole($roleName, $roleData['parent']);
			} else {
				$this->addRole($roleName);
			}
			if (array_key_exists('allow', $roleData)) {
				foreach ($roleData['allow'] as $resource) {
					if (!$this->hasResource($resource)) {
						$this->addResource($resource);
					}
					$this->allow($roleName, $resource);
				}
			}
		}
	}
}

