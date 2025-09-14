<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Manage My Services</h2>

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 mb-4 rounded">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php elseif (Yii::app()->user->hasFlash('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <?php foreach ($services as $service): ?>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="services[]" value="<?php echo $service->id; ?>"
                        <?php echo in_array($service->id, $selectedServices) ? 'checked' : ''; ?> />
                    <span><?php echo CHtml::encode($service->name); ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-6 rounded">
            Save Services
        </button>
    </form>
</div>

