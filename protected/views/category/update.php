<?php
/* @var $this Categoryontroller */
/* @var $model Category */

$this->pageTitle = 'Update Category';
$this->breadcrumbs = array(
    'Category' => array('index'),
    'Update',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>