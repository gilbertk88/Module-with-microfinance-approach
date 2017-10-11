<?php

class AccountController extends Controller
{
	//public $layout='//layouts/main';
	public $subLayout = "application.modules_core.space.views.space._layout";
	public function behaviors()
    {
        return array(
            'ProfileControllerBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceControllerBehavior',
            ),
        );
    } 
	public function beforeAction($action)
    {

        //$this->adminOnly();
        return parent::beforeAction($action);
    }
	public function actionIndex()
	{
		$this->render('index');
	}
public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	/*public function actionCreate()
	{
		$model=new Account;
		$space = $this->getSpace();
		

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		/*if (isset($_POST['ajax']) && $_POST['ajax'] === 'Account') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        } */

		/*if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$criteria = new CDbCriteria;
        $criteria->condition = "1";

        // Allow User Searches
        $search = Yii::app()->request->getQuery('search');
        if ($search != "") {
            $criteria->join = "LEFT JOIN user ON memberships.user_id = user.id ";
            $criteria->condition .= " AND (";
            $criteria->condition .= ' user.username LIKE :search';
            $criteria->condition .= ' OR user.email like :search';
            $criteria->condition .= " ) ";
            $criteria->params = array(':search' => '%' . $search . '%');
        }

        //ToDo: Better Counting
        $allMemberCount = count($space->memberships($criteria));

        $pages = new CPagination($allMemberCount);
        $pages->setPageSize($membersPerPage);
        $pages->applyLimit($criteria);

        $members = $space->memberships($criteria);

        $invited_members = SpaceMembership::model()->findAllByAttributes(array('space_id' => $space->id, 'status' => SpaceMembership::STATUS_INVITED));
		
		
		$this->render('create',array(
			'model'=>$model, 'space' => $space,
            'members' => $members, // must be the same as $item_count
            'invited_members' => $invited_members,
            'item_count' => $allMemberCount,
            'page_size' => $membersPerPage,
            'search' => $search,
            'pages' => $pages,
		));
	} */
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}