<?php
/* @var $this AccountController */
/* @var $model Account */
/*
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'View Account', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Account', 'url'=>array('admin')),
); */
?>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-10">

            <div class="panel panel-default">
                <div class="panel-body">
	
<h1>Update Account <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>
</div>
</div>