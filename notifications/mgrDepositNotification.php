<?php 
class mgrDepositNotification extends Notification{
	// Path to Web View of this Notification
	public $webView = "accounting.views.notifications.mgrDeposit";
	
	// Path to Mail Template for this notification
	public $mailView = "application.modules.accounting.views.notifications.mgrDeposit_mail";
		
	// Implement this method to handle clicks on the notification
	// Note: This is not used when your target_object is of type SIActiveRecordContent
	
	
	public static  function fire($userData){
		
		$notification = new Notification();
		$notification->class = "mgrDepositNotification";
		$notification->user_id = $userData['userId'];
		
		// Optional
		$notification->space_id = $userData['spaceId']; 
		
		$notification->source_object_model = "TransactionDetail";
		$notification->source_object_id = $userData['sObject_id'];
		
		$notification->target_object_model = 'TransactionDetail';
		$notification->target_object_id = $userData['tObject_id'];
		
		$notification->save();
		
	}
	
	public function redirectToTarget() {

        $target = $this->getTargetObject();  
        $notification = new Notification();
        
        //$notificationData = Space::model()->findByAttributes(array('id' =>4));
        $space_id=  $this->getSpaceguid($this->space_id);
           
       Yii::app()->getController()->redirect(Yii::app()->getController()->createUrl("//accounting/transactiondetail/notification", array(
       	'sguid' => $space_id->guid,
		'id' => $this->target_object_id,
		)));
       
    }	
}
?>