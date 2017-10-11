<?php 
class loanRepaymentNotification extends Notification{
	// Path to Web View of this Notification
	public $webView = "accounting.views.notifications.loanRepayment";
	
	// Path to Mail Template for this notification
	public $mailView = "application.modules.accounting.views.notifications.loanRepayment_mail";
	
	// Implement this method to handle clicks on the notification
	// Note: This is not used when your target_object is of type SIActiveRecordContent
	
	
	public static  function fire($userData){
		
		$notification = new Notification();
		$notification->class = "loanRepaymentNotification";
		$notification->user_id = $userData['userId'];
		
		// Optional
		$notification->space_id = $userData['spaceId']; // $userData['spaceId'];
		
		$notification->source_object_model = "TransactionDetail";
		$notification->source_object_id = $userData['sObject_id']; //$userData['tObject_id'];
		
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