<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		$defaultUrl = Yii::app()->getRequest()->getUrlReferrer();
		if ($defaultUrl &&(strpos($defaultUrl,'user/login')===false))
		{
			Yii::app()->user->setState('login_from_url',$defaultUrl);
		}		
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

}