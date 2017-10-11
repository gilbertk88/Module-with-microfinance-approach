<?php

class AccountingModule extends HWebModule
{
	public function behaviors()
    {
        return array(
            'SpaceModuleBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
            ),
            'UserModuleBehavior' => array(
                'class' => 'application.modules_core.user.behaviors.UserModuleBehavior',
            ),
        );
    }
	
	/*public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'accounting.models.*',
			'accounting.components.*',
		));
	} */
	
	public function getSpaceModuleDescription()
    {
        return 'Adds a transaction to this  SACCO.';
    }

    public function getUserModuleDescription()
    {
        return  'chama transaction';
    }

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
}
