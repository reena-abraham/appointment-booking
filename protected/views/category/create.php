<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->pageTitle = 'Create Category';
$this->breadcrumbs = array(
    'Category' => array('index'),
    'Create',
);
?>


<?php $this->renderPartial('_form', array('model' => $model)); ?>
