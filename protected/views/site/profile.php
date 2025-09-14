

<div class="max-w-5xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Profile</h1>

    <!-- Top Profile Card -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="relative w-24 h-24">
                <!-- Profile Image -->
                <img class="w-24 h-24 rounded-full object-cover border"
                    src="<?php echo Yii::app()->createUrl('site/profilePicture', array('id' => $user->id)); ?>"
                    alt="Profile">

                <!-- Overlay Button -->
                <form method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl('site/uploadPhoto'); ?>">
                    <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>">
                    <label for="upload-photo" class="absolute bottom-0 right-0 bg-white rounded-full p-1 border cursor-pointer shadow">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v2a2 2 0 002 2v7a2 2 0 002 2h8a2 2 0 002-2v-7a2 2 0 002-2V5a2 2 0 00-2-2H4zm2 3a1 1 0 100 2 1 1 0 000-2z" />
                        </svg>
                    </label>
                    <input id="upload-photo" name="profile_picture_file" type="file" class="hidden" onchange="this.form.submit()">
                </form>
            </div>

        </div>
    </div>

    <!-- Personal Info Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700">
            <div>
                <p class="font-medium text-gray-500">Full Name</p>
                <p><?php echo CHtml::encode($user->name); ?></p>
            </div>
            <div>
                <p class="font-medium text-gray-500">Email Address</p>
                <p><?php echo CHtml::encode($user->email); ?></p>
            </div>

           
            <div>
                <p class="font-medium text-gray-500">Status</p>
                <p class="<?php echo $user->is_active ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo $user->is_active ? 'Active' : 'Inactive'; ?>
                </p>
            </div>
        </div>
    </div>

<?php
/* @var $this EmployeeController */
/* @var $employee Employee */
/* @var $model ChangePasswordForm */
?>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="change-password-section bg-white p- rounded-lg shadow-md max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Change Password</h2>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'change-password-form',
        'action' => Yii::app()->createUrl('site/changePassword',array('id' => $user->id)),
        'enableAjaxValidation' => false,
    )); ?>

    <div class="form-group mb-4">
        <?php echo $form->labelEx($user, 'current_password', array('class' => 'block text-sm font-medium text-gray-700 mb-1')); ?>
        <?php echo $form->passwordField($user, 'current_password', array('class' => 'block w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500')); ?>
        <?php echo $form->error($user, 'current_password', array('class' => 'text-red-500 text-xs mt-1')); ?>
    </div>

    <div class="form-group mb-4">
        <?php echo $form->labelEx($user, 'new_password', array('class' => 'block text-sm font-medium text-gray-700 mb-1')); ?>
        <?php echo $form->passwordField($user, 'new_password', array('class' => 'block w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500')); ?>
        <?php echo $form->error($user, 'new_password', array('class' => 'text-red-500 text-xs mt-1')); ?>
    </div>

    <div class="form-group mb-6">
        <?php echo $form->labelEx($user, 'confirm_password', array('class' => 'block text-sm font-medium text-gray-700 mb-1')); ?>
        <?php echo $form->passwordField($user, 'confirm_password', array('class' => 'block w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500')); ?>
        <?php echo $form->error($user, 'confirm_password', array('class' => 'text-red-500 text-xs mt-1')); ?>
    </div>

    <div class="form-group">
        <?php echo CHtml::submitButton('Change Password', array('class' => 'w-full bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

</div>