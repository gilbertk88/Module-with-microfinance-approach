<?php
/**
 * This view represents a wall entry of a polls.
 * Used by PollWallEntryWidget to show Poll inside a wall.
 *
 * @property User $user the user which created this poll
 * @property Poll $poll the current poll
 * @property Space $space the current space
 *
 * @package humhub.modules.polls.widgets.views
 * @since 0.5
 */
?>
<div class="panel panel-default">
    <div class="panel-body">
       <?php $this->beginContent('application.modules_core.wall.views.wallLayout', array('object' => $Transactiondetail)); ?>
        <?php
        switch($Transactiondetail->account_id){
		case TransactionDetail::SAVINGS_AC_ID:
			switch ($Transactiondetail->type){
				case 'Cr':
					$direction='contributed';
					$moredetail='into savings';				
				break;
			
				case 'Dr':
					$direction='withdrew';
					$moredetail='from savings';					
					break;
			}
			
			$amount= 'KES '.Yii::app()->format->number($Transactiondetail->amount);
			echo '<strong>New transaction,</strong> '.$Transactiondetail->relatedUser->username.' '.$direction.' '.$amount.' '.$moredetail;			
			break;
		
		case TransactionDetail::MGR_AC_ID:
			switch ($Transactiondetail->type){
				case 'Cr':
					$direction='contributed';
					$moredetail='into merry go round';
					break;
						
				case 'Dr':
					$direction='received';
					$moredetail='from merry go round';
					break;
			}
						
				
			$amount= 'KES '.Yii::app()->format->number($Transactiondetail->amount);
			echo '<strong>New transaction,</strong> '.$Transactiondetail->relatedUser->username.' '.$direction.' '.$amount.' '.$moredetail;
			
			break;
		case TransactionDetail::LOAN_AC_ID:
			switch ($Transactiondetail->type){
				case 'Dr':
					$direction='received a loan.';	
					break;
			
				case 'Cr':
					$direction='paid a loan';
					break;
			}			
			
			echo '<strong>New transaction,</strong> '. $Transactiondetail->relatedUser->username.' '.$direction;
			break;
        }
         
        ?>
 <?php $this->endContent(); ?>
</div></div> 