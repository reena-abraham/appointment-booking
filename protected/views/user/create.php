<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->pageTitle = 'Create User';
$this->breadcrumbs = array(
    'User' => array('index'),
    'Create',
);
?>


<?php $this->renderPartial('_form', array('model' => $model)); ?>
