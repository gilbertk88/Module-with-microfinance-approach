<?php $this->beginContent('application.modules_core.notification.views.notificationLayout', array('notification' => $notification)); ?>
<?php echo Yii::t('SpaceModule.views_notifications_invite', '{userName} issued funds from a merry go round pool in {spaceName}', array(
    '{userName}' => '<strong>' . CHtml::encode($creator->displayName) . '</strong>',
    '{spaceName}' => '<strong>' . CHtml::encode($space->name) . '</strong>'
)); ?>
<?php $this->endContent(); ?>