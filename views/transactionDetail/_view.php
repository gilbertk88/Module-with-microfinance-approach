<?php
/* @var $this TransactionDetailController */
/* @var $data TransactionDetail */
?>

<tr class="">

		<td>
		<?php echo CHtml::link(CHtml::encode($data->relatedUser->username), array('/user/profile','uguid'=>$data->relatedUser->guid)); ?>
		</td>
		
		<td>
		<?php echo CHtml::encode($data->Detail); ?>
		</td>

		<td>
		<b><?php echo CHtml::encode(Yii::app()->format->number($data->amount)); ?></b>
		</td>
		
		<td>
		<?php echo CHtml::encode(Yii::app()->format->datetime($data->created_at)); ?>
		</td>
		<td>
		<b><?php echo CHtml::link(CHtml::htmlButton('view',array('class'=>'')),array('view','sguid'=>Yii::app()->getController()->getSpace()->guid,'id'=>$data->id)); ?></b>
		</td>


</tr>