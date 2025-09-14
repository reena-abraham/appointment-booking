<?php
/* @var $this ServiceTypeController */
/* @var $model ServiceType */

$this->pageTitle = 'Update Service Type';
$this->breadcrumbs = array(
    'Service Type' => array('index'),
    'Update',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>