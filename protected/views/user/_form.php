<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-2">
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500">
            <a href="<?php echo $this->createUrl('admin/dashboard'); ?>" class="hover:underline">Home</a> &gt;
            <a href="<?php echo $this->createUrl('user/admin'); ?>" class="hover:underline">Employee</a> &gt; 
            <span><?php echo $model->isNewRecord ? 'Add User' : 'Edit User'; ?></span>
        </nav>
    </div>

    <h2 class="text-2xl font-bold mb-6">
        <?php echo $model->isNewRecord ? 'Add User' : 'Edit User'; ?>
    </h2>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'action' => $model->isNewRecord
            ? $this->createUrl('user/create')
            : $this->createUrl('user/update', ['id' => $model->id]),
    )); ?>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Name -->
    <div>
        <?php echo $form->labelEx($model, 'name', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
        <?php echo $form->textField($model, 'name', ['class' => 'form-input w-full border border-gray-300 rounded-lg p-2.5']); ?>
        <?php echo $form->error($model, 'name', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>

    <!-- Email -->
    <div>
        <?php echo $form->labelEx($model, 'email', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
        <?php echo $form->textField($model, 'email', ['class' => 'form-input w-full border border-gray-300 rounded-lg p-2.5']); ?>
        <?php echo $form->error($model, 'email', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>
    <div>
        <?php echo $form->labelEx($model, 'password', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
        <?php echo $form->passwordField($model, 'password', ['class' => 'form-input w-full border border-gray-300 rounded-lg p-2.5']); ?>
        <?php echo $form->error($model, 'password', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>
    <!-- Department -->

    
    

    <!-- Status -->
    <div>
        <?php echo $form->labelEx($model, 'status', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
        <?php echo $form->dropDownList(
            $model,
            'status',
            [1 => 'Active', 0 => 'Inactive'],
            ['class' => 'form-select w-full border border-gray-300 rounded-lg p-2.5', 'prompt' => 'Select Status']
        ); ?>
        <?php echo $form->error($model, 'status', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>

     <div>
        <?php echo $form->labelEx($model, 'role', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
        <?php echo $form->textField($model, 'role', ['class' => 'form-input w-full border border-gray-300 rounded-lg p-2.5']); ?>
        <?php echo $form->error($model, 'role', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>

    <!-- Profile Picture (optional full width) -->


</div>


    <!-- Submit Button -->
    <div class="mt-4 flex justify-start">
        <?php echo CHtml::submitButton(
            $model->isNewRecord ? 'Create' : 'Save',
            ['class' => 'bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-6 rounded']
        ); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
