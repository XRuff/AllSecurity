<?php

namespace XRuff\App\Security;

use	Nette\Object;
use	Nette\Security\IAuthorizator;

class UserAuthorizator extends Object implements IAuthorizator {

	public $acl;

	public function __construct(array $config) {
		$this->acl = new Acl($config);
	}

	function isAllowed($role, $resource, $privilege) {
		return $this->acl->isAllowed($role, $resource, $privilege);
	}
}

