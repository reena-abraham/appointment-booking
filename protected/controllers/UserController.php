<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'users' => array('@'),
				'expression' => 'Yii::app()->user->getState("role") === "admin"',
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Users'])) {
			$model->attributes = $_POST['Users'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Users'])) {
			$model->attributes = $_POST['Users'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->join = 'JOIN user_roles ur ON ur.user_id = t.id';
		$criteria->condition = 'ur.role_id = 2';
		$dataProvider = new CActiveDataProvider('Users', array(
			'criteria' => $criteria,
		));
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionList()
	{

		$model = new User();
		$dataProvider = $model->getAllUsers();

		$this->render('list', array(
			'model' => $model,
			'dataProvider' => $dataProvider,
		));
	}
	public function actionDetails($userId)
	{

		// Fetch user details
		$user = User::model()->findByPk($userId);

		if (!$user) {
			throw new CHttpException(404, 'User not found.');
		}

		// Get appointments for the user
		// $appointments = Appointment::model()->with('user', 'staff', 'category', 'service')
		//     ->findAll('t.user_id = :user_id', [':user_id' => $userId]);
		if ($user->role === 'customer') {
			// Appointments booked by this customer
			$appointments = Appointment::model()
				->with('user', 'staff', 'category', 'service')
				->findAll('t.user_id = :user_id', [':user_id' => $userId]);
		} elseif ($user->role === 'employee') {
			// Appointments assigned to this employee
			$appointments = Appointment::model()
				->with('user', 'staff', 'category', 'service')
				->findAll('t.staff_id = :staff_id', [':staff_id' => $userId]);
		} else {
			// Unknown role
			throw new CHttpException(403, 'Invalid user role.');
		}
		// Aggregate appointment data for graphical representation (appointments per category)
		$appointmentsByCategory = Yii::app()->db->createCommand()
			->select('c.name, COUNT(*) as count')
			->from('appointment a')
			->join('categories c', 'a.category_id = c.id')
			->where('a.user_id = :user_id', [':user_id' => $userId])
			->group('c.name')
			->queryAll();

		// Prepare data for chart (pie or bar chart)
		$categories = [];
		$counts = [];
		foreach ($appointmentsByCategory as $data) {
			$categories[] = $data['name'];
			$counts[] = (int) $data['count'];
		}

		// Pass data to the view
		$this->render('userdetails', [
			'user' => $user,
			'appointments' => $appointments,
			'categories' => json_encode($categories), // Data for chart categories
			'counts' => json_encode($counts), // Data for chart counts
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
