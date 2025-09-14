<?php

class CategoryController extends Controller
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

	public function actionList()
	{
		$model = new Category();
		$dataProvider = $model->getAllCategory();
		// print_r($dataProvider);exit;
		$this->render('list', array(
			'model' => $model,
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Category'])) {
			$model->attributes = $_POST['Category'];
			if ($model->validate()) {
				if (isset($_FILES['Category']['name']['image']) && $_FILES['Category']['name']['image'] != '') {
					$uploadedFile = CUploadedFile::getInstance($model, 'image');
					$fileName = time() . '_' . $uploadedFile->name;  // You can modify this to create unique names

					// Save the file in the 'uploads' directory
					$filePath = Yii::getPathOfAlias('webroot') . '/uploads/categories/' . $fileName;
					if ($uploadedFile->saveAs($filePath)) {
						// Save file path in the database
						$model->image = $fileName;
					}
				}
				if ($model->save()) {
					$this->redirect(array('list'));
				}
			}
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

		if (isset($_POST['Category'])) {
			$model->attributes = $_POST['Category'];
			if ($model->validate()) {
				if (isset($_FILES['Category']['name']['image']) && $_FILES['Category']['name']['image'] != '') {
					$uploadedFile = CUploadedFile::getInstance($model, 'image');
					$fileName = time() . '_' . $uploadedFile->name;  // Unique file name
					//print_r('fff');exit;
					// Delete the old image if there's one (optional but recommended to avoid clutter)
					if ($model->image) {
						$oldImagePath = Yii::getPathOfAlias('webroot') . $model->image;
						if (file_exists($oldImagePath)) {
							unlink($oldImagePath);  // Delete the old image
						}
					}

					// Save the new image to the 'uploads' folder
					$filePath = Yii::getPathOfAlias('webroot') . '/uploads/categories/' . $fileName;
					if ($uploadedFile->saveAs($filePath)) {
						// Update the image path in the database
						$model->image = $fileName;
					}
				}
			//	print_r('vvvv');exit;
				if ($model->save())
					$this->redirect(array('list'));
			}
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('list'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Department');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Category::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Department $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'department-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
