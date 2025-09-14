<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if (isset($_POST['ContactForm'])) {
			$model->attributes = $_POST['ContactForm'];
			if ($model->validate()) {
				$name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
				$subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
				$headers = "From: $name <{$model->email}>\r\n" .
					"Reply-To: {$model->email}\r\n" .
					"MIME-Version: 1.0\r\n" .
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
				Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact', array('model' => $model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate() && $model->login()) {
				$user = User::model()->findByPk(Yii::app()->user->id);
				if ($user->role === 'admin') {
					$this->redirect(array('admin/dashboard'));
				} elseif ($user->role === 'employee') {
					$this->redirect(array('employee/dashboard'));
				} else {
					$this->redirect(Yii::app()->homeUrl); // customer
				}
			}
		}

		$this->render('login', array('model' => $model));
	}
	public function actionRegister()
	{
		$user = new User;
		$employee = new Employee;

		if (isset($_POST['User'])) {
			$user->attributes = $_POST['User'];
			if ($user->validate()) {
				// Hash password before saving
				// $user->password = CPasswordHelper::hashPassword('123456');
				$user->password = CPasswordHelper::hashPassword($user->password);
				// print_r($user);exit;
				if ($user->save()) {
					// Save provider info only if role is employee (service provider)
					if ($user->role === 'employee') {
						$employee->user_id = $user->id;
						$employee->category_id = $_POST['Employee']['category_id'];;

						if (!$employee->save()) {
							// 	 var_dump($employee->getErrors());
							// Yii::app()->end();
							// Handle error if needed
							Yii::app()->user->setFlash('error', 'Failed to save employee information.');
						}
					}

					Yii::app()->user->setFlash('success', 'Registration successful!');
					$this->redirect(array('site/login'));
				}
			}
		}

		$this->render('register', [
			'user' => $user,
			'employee' => $employee,
		]);
	}

	public function actionProfile()
	{
		if (Yii::app()->user->role != 'customer') {
			throw new CHttpException(403, 'You are not authorized to access this page.');
		}
		$id = Yii::app()->user->id;
		$user = User::model()->findByPk($id);
		$this->render('profile', ['user' => $user]);
	}
	public function actionChangePassword($id)
	{
		$user = User::model()->findByPk($id);
		if ($user === null) {
			throw new CHttpException(404, 'The requested user does not exist.');
		}
		$user->setScenario('changePassword');
		if (isset($_POST['User'])) {
			$user->attributes = $_POST['User'];
			if (!CPasswordHelper::verifyPassword($user->current_password, $user->password)) {
				$user->addError('current_password', 'Incorrect current password.');
			}
			if (!$user->hasErrors()) {
				$user->password = CPasswordHelper::hashPassword($empuserloyee->new_password);

				if ($user->save()) {
					Yii::app()->user->setFlash('success', 'Password updated successfully.');
					$this->redirect(array('profile', 'id' => $user->id));
				}
			}
		}

		$this->render('profile', array('user' => $user));
	}

	public function actionMyAppointments()
	{
		$userId = Yii::app()->user->id;

		$criteriaUpcoming = new CDbCriteria();
		$criteriaUpcoming->condition = 'user_id = :uid AND appointment_date >= CURDATE()';
		$criteriaUpcoming->params = [':uid' => $userId];
		$criteriaUpcoming->order = 'appointment_date ASC';

		$criteriaPast = new CDbCriteria();
		$criteriaPast->condition = 'user_id = :uid AND appointment_date < CURDATE()';
		$criteriaPast->params = [':uid' => $userId];
		$criteriaPast->order = 'appointment_date DESC';

		$upcomingAppointments = Appointment::model()->findAll($criteriaUpcoming);
		$pastAppointments = Appointment::model()->findAll($criteriaPast);

		$this->render('myAppointments', [
			'upcomingAppointments' => $upcomingAppointments,
			'pastAppointments' => $pastAppointments,
		]);
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
