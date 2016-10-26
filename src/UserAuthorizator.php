<?php

namespace XRuff\App\Security;

use Nette\Object;
use Nette\Security\IAuthorizator;

/**
 * @author Pavel Lauko <info@webengine.cz>
 */
class UserAuthorizator extends Object implements IAuthorizator
{
	/** @var Acl */
	public $acl;

	/**
	 * @param Acl $acl
	 */
	public function __construct(Acl $acl)
	{
		$this->acl = $acl;
	}

	/**
	 * @param string $role
	 * @param string $resource
	 * @param string $privilege
	 */
	function isAllowed($role, $resource, $privilege)
	{
		return $this->acl->isAllowed($role, $resource, $privilege);
	}
}
