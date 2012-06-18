<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		
		if (Yii::app()->user->isGuest) {
			$defaultUrl = Yii::app()->getRequest()->getUrlReferrer();
			if ($defaultUrl &&(strpos($defaultUrl,'user/login')===false))
			{
				Yii::app()->user->setState('login_from_url',$defaultUrl);
			}
			
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					if(Yii::app()->user->getState('login_from_url'))
					{
						Yii::app()->user->setReturnUrl(Yii::app()->user->getState('login_from_url'));
						Yii::app()->user->setState('login_from_url',null);
					}
					$this->lastViset();
					if (Yii::app()->user->returnUrl=='/index.php')
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}