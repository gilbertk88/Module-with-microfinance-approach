<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
<div class="text-right">
<?php
if($isadmin){
	echo CHtml::link(CHtml::htmlButton('All member list',array('class'=>'individualreport pull-right btn btn-primary')),array('//accounting/transactiondetail/index','sguid'=>$space->guid));
	echo ' '.CHtml::link(CHtml::htmlButton('Individual member list',array('class'=>'individualreport pull-right btn btn-primary')),array('//accounting/transactiondetail/index','indiv'=>1,'sguid'=>$space->guid));
	}
?>
</div>
<center class="reporthead"><h1><b>
<?php 
	if ($isadmin)
		echo CHtml::label(CHtml::encode('Transactions for '.$memberData) ,'','');
	else 
		echo CHtml::label(CHtml::encode('My Transactions'),'','');
?>
</b></h1></center>

<table class= "table table-hover">
	<thead>
		<td><?php echo CHtml::label(CHtml::encode('Member'),'',''); ?></td>
		<td><?php echo CHtml::label(CHtml::encode('Description'),'',''); ?></td>
		<td><?php echo CHtml::label(CHtml::encode('Amount'),'',''); ?></td>
		<td><?php echo CHtml::label(CHtml::encode('Time'),'',''); ?></td>
	</thead>



<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	//'space'=>$space,
	'itemView'=>'_view',
)); ?>
</table>
</div>
</div>
</div>
</div>
</div>