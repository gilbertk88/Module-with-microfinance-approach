<?php $this->beginContent('application.modules_core.notification.views.notificationLayoutMail', array('notification' => $notification)); ?>
<?php echo Yii::t('SpaceModule.views_notifications_inviteAccepted', '{userName} accepted your invite for the  SACCO {spaceName}', array(
    '{userName}' => '<strong>' . CHtml::encode($creator->displayName) . '</strong>',
    '{spaceName}' => '<strong>' . CHtml::encode($targetObject->name) . '</strong>'
)); ?>
<?php $this->endContent(); ?>