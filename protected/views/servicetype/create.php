<?php
/* @var $this DesignationController */
/* @var $model Designation */

$this->pageTitle = 'Create Designation';
$this->breadcrumbs = array(
    'Designation' => array('index'),
    'Create',
);
?>
<!-- 
<h1>Create Designation</h1> -->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>