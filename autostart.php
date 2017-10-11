<?php

Yii::app()->moduleManager->register(array(
    'id' => 'accounting',
    'class' => 'application.modules.accounting.AccountingModule',
    'import' => array(
	    'application.modules.accounting.*',
        'application.modules.accounting.models.*',
        'application.modules.accounting.notifications.*'
      ),
    'events' => array(
       array('class' => 'SpaceMenuWidget', 'event' => 'onInit', 'callback' => array('AccountingModuleEvents', 'onSpaceMenuInit')),
       array('class' => 'SpaceSidebarWidget', 'event' => 'onInit', 'callback' => array('AccountingModuleEvents', 'onSpaceSidebarInit')),
       array('class' => 'ZCronRunner', 'event' => 'onDailyRun', 'callback' => array('AccountingModuleEvents', 'onLoanInterest')),
    ),
));
?>