# Quickstart

Installation
-----------

The best way to install XRuff/AppSecurity is using  [Composer](http://getcomposer.org/):

```sh
$ composer require XRuff/AppSecurity
```

Settings
-----------
With Nette `2.1` and newer, you can enable the extension using your neon config. Look at comments in `config.neon` file:

```yml
extensions:
	acl: XRuff\App\Security\DI\AclExtension

acl:
	guest:
		allow:
			- Homepage
	demo:
		parent: guest #  inherit all properties from role guest
	user:
		parent: guest
		allow:
			- Stats: [ view ] # only view action allowed
			- Partners: [ view, create, update, delete ] # allowed all listed actions
			- Activities: [ view, create, update, delete ]
			- Settings: [ view, update ]
			- Logout # if no action listed, only view action is allowed
	premium:
		parent: user #  inherit all properties from role user
		allow:
			- Partners: [ invite ]
			- Activities: [ shere ] # only shere action allowed
			- Export
	admin:
		parent: user
		allow:
			- Settings: [ delete ] # extends 'Settings' resource of user role with delete action
	superadmin:
		parent: admin #  inherit all properties from role admin
		allow:
			- Admin:Homepage
```

Usage
-----------

Sett Authorizator into user object :

```php

use Nette;
use XRuff\App\Security\Acl;

class BasePresenter extends Nette\Application\UI\Presenter
{
  /** @var Acl @inject */
  public $authorizator;

  protected function startup()
  {
    parent::startup();
    $this->user->setAuthorizator($this->authorizator);
  }
}
```
and use in app/AdminModule/presenters/BasePresenter.php, like:

```php
namespace AdminModule;

class BasePresenter extends \BasePresenter
{
  public function actionShare($id)
  {
    if (!$this->user->isAllowed('Activities', 'share')) {
      $this->flashMessage('Access denied');
      $this->redirect('Default:');
    }
  }
}
```

How does authorizator, visit Nette documentation page [User Authorization and Privileges](https://doc.nette.org/en/2.4/access-control#toc-authorizator)