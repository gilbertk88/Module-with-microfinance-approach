<?php

class AccountingModuleEvents extends HWebModule
    {

        public function behaviors()
        {

            return array(
                'SpaceModuleBehavior' => array(
                    'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
                ),
            );
        }


    public static function onTopMenuInit($event)
    {
        if (Yii::app()->user->isGuest) {
            return;
        }

        $user = Yii::app()->user->getModel();
       // if ($user->isModuleEnabled('calendar')) {
            $event->sender->addItem(array(
                'label' => 'Accounting',
                'url' => Yii::app()->createUrl('//calendar/global/index', array('uguid' => Yii::app()->user->guid)),
                'icon' => '<i class="fa fa-calendar"></i>',
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'calendar' && Yii::app()->controller->id == 'global'),
                
            ));
        //}
    }

    public static function onSpaceMenuInit($event)
    {
        $space = Yii::app()->getController()->getSpace();
        
           $space = Yii::app()->getController()->getSpace();
          
           /* if ($space->isAdmin()) {            	
            $event->sender->addItem(array(
            		'label' => 'Transactions',
            		'group' => 'modules',
            		'url' => '',
            		'icon' => '<i class="fa fa-plus"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'accounting'),
            		'sortOrder' => 1,
            		'htmlOptions'=>array('class'=>'transaction'),
            ));
            
            $event->sender->addItem(array(
            		'label' => 'Savings/ Share',
            		'group' => 'modules',
            		'url' => '',
            		'icon' => '<i class="fa fa-dollar"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'save'),
            		'sortOrder' => 2,
            		'htmlOptions'=>array('class'=>' list-group-item savings-menu'),            		
            ));
            $event->sender->addItem(array(
            		'label' => 'Deposit',
            		'group' => 'modules',
            		'url' => Yii::app()->createUrl('//accounting/transactiondetail/contribution',array('sguid'=>$space->guid,'transid'=>1,'trans_dir'=>1)),
            		'icon' => '<i class="fa fa-plus-circle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'save'),
            		'sortOrder' => 3,
            		'htmlOptions'=>array('class'=>' list-group-item savings-drop-down'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Withdraw',
            		'group' => 'modules',
            		'url' => Yii::app()->createUrl('//accounting/transactiondetail/contribution',array('sguid'=>$space->guid,'transid'=>1,'trans_dir'=>2)),
            		'icon' => '<i class="fa fa-minus-circle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'save'),
            		'sortOrder' => 4,
            		'htmlOptions'=>array('class'=>' list-group-item savings-drop-down'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Merry go round</b>',
            		'group' => 'modules',
            		'url' => '',
            		'icon' => '<i class="fa fa-recycle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'mgr'),
            		'sortOrder' => 5,
            		'htmlOptions'=>array('class'=>' list-group-item merry-go-round-menu'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Contribute',
            		'group' => 'modules',
            		'url' => Yii::app()->createUrl('//accounting/transactiondetail/contribution',array('sguid'=>$space->guid,'transid'=>2,'trans_dir'=>1)),
            		'icon' => '<i class="fa fa-plus-circle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'mgr'),
            		'sortOrder' => 6,
            		'htmlOptions'=>array('class'=>' list-group-item merry-go-round-drop-down'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Issue',
            		'group' => 'modules',
            		'url' => Yii::app()->createUrl('//accounting/transactiondetail/contribution',array('sguid'=>$space->guid,'transid'=>2,'trans_dir'=>2)),
            		'icon' => '<i class="fa fa-minus-circle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'mgr'),
            		'sortOrder' => 7,
            		'htmlOptions'=>array('class'=>' list-group-item merry-go-round-drop-down'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Loan',
            		'group' => 'modules',
            		'url' => '',
            		'icon' => '<i class="fa fa-bank"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'loan'),
            		'sortOrder' => 8,
            		'htmlOptions'=>array('class'=>' list-group-item loan-menu'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Issue',
            		'group' => 'modules',
            		'url' =>Yii::app()->createUrl('//accounting/transactiondetail/contribution',array('sguid'=>$space->guid,'transid'=>3,'trans_dir'=>1)),
            		'icon' => '<i class="fa fa-plus-circle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'loan'),
            		'sortOrder' => 9,
            		'htmlOptions'=>array('class'=>' list-group-item loan-drop-down'),
            ));
            $event->sender->addItem(array(
            		'label' => 'Pay',
            		'group' => 'modules',
            		'url' => Yii::app()->createUrl('//accounting/transactiondetail/contribution',array('sguid'=>$space->guid,'transid'=>3,'trans_dir'=>2)),
            		'icon' => '<i class="fa fa-minus-circle"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'loan'),
            		'sortOrder' => 10,
            		'htmlOptions'=>array('class'=>' list-group-item loan-drop-down'),
            ));
            $event->sender->addItem(array(
            		'label' => 'All trantactions',
            		'group' => 'modules',
            		'url' =>  Yii::app()->createUrl('//accounting/transactiondetail/index',array('sguid'=>$space->guid)),
            		'icon' => '<i class="fa fa-align-justify"></i>',
            		'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'save'),
            		'sortOrder' => 11,
            		'htmlOptions'=>array('class'=>' list-group-item alltransacction-menu transdrop-menu'),
            ));
            }
           
            
             $event->sender->addItem(array(
            			'label' => 'Collaborate',
            			'group' => 'modules',
            			'url' => '',
            			'icon' => '<i class="fa fa-puzzle-piece"></i>',
            			'isActive' => '',
            			'sortOrder' => 11,
            			'htmlOptions'=>array('class'=>' list-group-item collaboration-drop'),
            	));
            	$event->sender->addItem(array(
            			'label' => 'Documents',
            			'group' => 'modules',
            			'url' => '',
            			'icon' => '<i class="fa fa-file"></i>',
            			'isActive' => '',
            			'sortOrder' => 15,
            			'htmlOptions'=>array('class'=>' list-group-item documentation-drop'),
            	));
            	
           	$event->sender->addItem(array(
            			'label' => 'My Reports',
            			'group' => 'modules',
            			'url' => '',
            			'icon' => '<i class="fa fa-pie-chart"></i>',
            			'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'reports'),
            			'sortOrder' => 18,
            			'htmlOptions'=>array('class'=>' list-group-item report-drop'),
            	));
            	$event->sender->addItem(array(
            			'label' => 'SACCO',
            			'group' => 'modules',
            			'url' => Yii::app()->createUrl('//accounting/transactiondetail/report', array('sguid' => $space->guid)),
            			'icon' => '<i class="fa fa-group"></i>',
            			'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'reports'),
            			'sortOrder' => 19,
            			'htmlOptions'=>array('class'=>' list-group-item report-drop-down'),
            	));
            	$event->sender->addItem(array(
            			'label' => 'Personal',
            			'group' => 'modules',
            			'url' => Yii::app()->createUrl('//space/mlist/reports', array('sguid' => $space->guid)),
            			'icon' => '<i class="fa fa-user"></i>',
            			'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'reports'),
            			'sortOrder' => 20,
            			'htmlOptions'=>array('class'=>' list-group-item report-drop-down'),
            	)); */
        //}      
    }

    public static function onProfileMenuInit($event)
    {
               
        $user = Yii::app()->getController()->getUser();

        // Is Module enabled on this workspace?
        //if ($user->isModuleEnabled('calendar')) {
            $event->sender->addItem(array(
                'label' => 'Accounting',
                'url' => Yii::app()->createUrl('//calendar/view/index', array('uguid' => $user->guid)),
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'calendar'),
            ));
        //}
    }

    public static function onSpaceSidebarInit($event)
    {
        
        if (Yii::app()->user->isGuest) {
            return;
        }
                
        $space = null;

        if (isset(Yii::app()->params['currentSpace'])) {
            $space = Yii::app()->params['currentSpace'];
        }

        if (Yii::app()->getController() instanceof ContentContainerController && Yii::app()->getController()->contentContainer instanceof Space) {
            $space = Yii::app()->getController()->contentContainer;
        }

        if ($space != null) {
            if ($space->isModuleEnabled('calendar')) {
                $event->sender->addWidget('application.modules.calendar.widgets.NextEventsSidebarWidget', array('contentContainer' => $space), array('sortOrder' => 550));
            }
        }
    }

    public static function onDashboardSidebarInit($event)
    {
        if (Yii::app()->user->isGuest) {
            return;
        }

        $user = Yii::app()->user->getModel();
        if ($user->isModuleEnabled('calendar')) {
            $event->sender->addWidget('application.modules.calendar.widgets.NextEventsSidebarWidget', array(), array('sortOrder' => 550));
        }
    }

    public static function onProfileSidebarInit($event)
    {
        
        if (Yii::app()->user->isGuest) {
            return;
        }
                
        $user = null;

        if (isset(Yii::app()->params['currentUser'])) {
            $user = Yii::app()->params['currentUser'];
        }

        if (Yii::app()->getController() instanceof ContentContainerController && Yii::app()->getController()->contentContainer instanceof User) {
            $user = Yii::app()->getController()->contentContainer;
        }

        if ($user != null) {
            if ($user->isModuleEnabled('calendar')) {
                $event->sender->addWidget('application.modules.calendar.widgets.NextEventsSidebarWidget', array('contentContainer' => $user), array('sortOrder' => 550));
            }
        }
    }
    
     public static function onLoanInterest()
    {
    	//$charge_date= today
    	$charge_date=time();
    	$loanInterest=LoanInterest::model()->findAllByAttributes(array('status'=>1,'charge_date'=>$charge_date));
    	$loanInterestNo=count($loanInterest);
    	for ($i=0;$i<$loanInterestNo;$i++){
    		TransactionDetailController::chargeInterest($loanInterest[$i]['id']);
    	}
    }
}
