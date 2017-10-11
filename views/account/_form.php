<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class' => 'form-control','size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'Type'); ?>
		<?php echo $form->dropDownlist($model,'Type',array('1'=>'Asset','2'=>'Liability','3'=>'Equity','4'=>'Income','5'=>'Expenses'),array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'Type'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'space_individualtype'); ?>
		<?php echo $form->dropDownlist($model,'space_individualtype',array('1'=>'Space', '2'=> 'Individual in a space'),array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'space_individualtype'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'system_user'); ?>
		<?php echo $form->dropDownlist($model,'system_user',array('1'=>'System admin only can modify', '2'=>'User can modify'),array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'system_user'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'space_id'); ?>
		<?php echo $form->textField($model,'space_id',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'space_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'related_user_id'); ?>
		<select name="ownerId" class="form-control">
                            <?php foreach ($space->memberships as $membership) : ?>
                                <?php if ($membership->user == null) continue; ?>
                                <option
                                    value="<?php echo $membership->user->id; ?>" <?php if ($space->isSpaceOwner($membership->user->id)): ?> selected <?php endif; ?>><?php echo CHtml::encode($membership->user->displayName); ?></option>
                            <?php endforeach; ?>
         </select>
		<?php //echo $form->textField($model,'related_user_id',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'related_user_id'); ?>
	</div><br>
	<div class=" buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=> 'btn btn-primary' )); ?>
		

		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->