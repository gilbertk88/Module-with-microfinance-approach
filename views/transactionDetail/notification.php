<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
<?php 
$trans_type_id=array(1=>'Savings',2=>'Merry go round',3=>'Loan',/*4=>'Projects'*/);
$trans_setting_type=$trans_type_id[$model->trans_setting_type];
echo '<h1>'.$trans_setting_type.' Transaction #'.$model->id.'</h1><div class="text-right">'.$model->created_at.'</div>';
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'related_user_id'=>array('label'=>'Member','type'=>'raw','value'=>CHtml::link(CHtml::encode($model->relatedUser->username), array('/user/profile','uguid'=>$model->relatedUser->guid))),
		'amount'=>array('label'=>'Amount','value'=>Yii::app()->format->number($model->amount)),
		'Detail'=>array('label'=>'Details','value'=>$model->Detail),
	),
	
)); 
echo '<br>'.CHtml::link(CHtml::htmlButton('All transactions',array('class'=>'btn btn-primary')),array('index','sguid'=>$space->guid));
?>
</div>
</div>
</div>
</div>
</div>