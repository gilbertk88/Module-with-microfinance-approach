<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
	
	<?php
/* @var $this TransactionDetailController */
/* @var $model TransactionDetail */
/*
$this->breadcrumbs=array(
	'Transaction Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionDetail', 'url'=>array('create')),
);
 */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transaction-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Contributions</h1>

<p>
Enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'transaction_id',
		//'account_id',
		//'type',
		array(
			'name'=>'transaction.relatedUser.username',
			'type'=>'raw',
			/*'filter'=>CHtml::dropDownList('Provider[onoff]', '',  
                array(
                    ''=>'All',
                    '1'=>'On',
                    '0'=>'Off',
                )
            ), */
			'value'=>$model->transaction->relatedUser->username),
			//'amount'=>array('label'=>'Amount','value'=>Yii::app()->format->number($model->amount)),
			array('name'=>'transaction.Detail','value'=>$model->transaction->Detail),
			'amount',
			array('name'=>'transaction.date','value'=>$model->transaction->date),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>
</div>
</div>