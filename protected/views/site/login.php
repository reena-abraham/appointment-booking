<main class="bg-gray-50">
	<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 pt:mt-0">

		<!-- Card -->
		<div class="bg-white shadow rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
			<div class="p-6 sm:p-8 lg:p-16 space-y-8">
				<h2 class="text-2xl lg:text-3xl font-bold text-gray-900 text-center">
					Sign in
				</h2>
				<?php if (Yii::app()->user->hasFlash('loginError')): ?>
					<div style="color: red;">
						<?php echo Yii::app()->user->getFlash('loginError'); ?>
					</div>
				<?php endif; ?>
				<?php $form = $this->beginWidget('CActiveForm', [
					'id' => 'login-form',
					'enableClientValidation' => true,
					'clientOptions' => ['validateOnSubmit' => true],
					'htmlOptions' => ['class' => 'mt-8 space-y-6'],
				]); ?>

				<div>
					<?php echo $form->labelEx($model, 'username', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
					<?php echo $form->textField($model, 'username', [
						'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5',
						'placeholder' => 'Enter username',
					]); ?>
					<?php echo $form->error($model, 'username', ['class' => 'text-red-600 text-sm mt-1']); ?>
				</div>

				<div>
					<?php echo $form->labelEx($model, 'password', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
					<?php echo $form->passwordField($model, 'password', [
						'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5',
						'placeholder' => '••••••••',
					]); ?>
					<?php echo $form->error($model, 'password', ['class' => 'text-red-600 text-sm mt-1']); ?>
				</div>

				<div class="flex items-center justify-between">
					<label class="flex items-center text-sm text-gray-900" for="LoginForm_rememberMe">
						<?php echo $form->checkBox($model, 'rememberMe', [
							'class' => 'bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded',
						]); ?>
						<span class="ml-2">Remember me</span>
					</label>
				</div>

				<button type="submit" class="w-full sm:w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 text-center">
					Login
				</button>

				<div class="text-sm font-medium text-gray-500 text-center">
					Not registered? <a href="<?php echo Yii::app()->createUrl('site/register'); ?>" class="text-teal-500 hover:underline">Create account</a>
				</div>

				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</main>