


<?php
$currentStep = 5;
$steps = [
    1 => 'Step1',
    2 => 'Step2',
    3 => 'Step3',
    4 => 'Step4',
    5 => 'Stp5',
];

?>

<div class="max-w-3xl mx-auto my-12 p-6 bg-white rounded-lg shadow-lg">
      <!-- Step Indicator -->
    <div class="flex items-center justify-center mb-10">
        <ol class="flex items-center w-full max-w-3xl space-x-4 text-sm text-gray-500 sm:space-x-6">
            <?php foreach ($steps as $stepNumber => $stepLabel): ?>
                <!-- Step Item -->
                <li class="flex items-center <?php echo $stepNumber === $currentStep ? 'text-blue-600 font-medium' : ($stepNumber < $currentStep ? 'text-green-600 line-through' : 'text-gray-400'); ?>">
                    <span class="flex items-center justify-center w-8 h-8 border <?php echo $stepNumber <= $currentStep ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'; ?> rounded-full mr-2">
                        <?php echo $stepNumber; ?>
                    </span>
                    <?php echo CHtml::encode($stepLabel); ?>
                </li>

                <!-- Divider except after last -->
                <?php if ($stepNumber < count($steps)): ?>
                    <li class="flex-1 border-t-2 <?php echo $stepNumber < $currentStep ? 'border-green-600' : ($stepNumber === $currentStep ? 'border-blue-600' : 'border-gray-300'); ?>"></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </div>
    <!-- Step Title -->
    <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Confirm Your Booking</h2>

    <!-- Booking Details Summary -->
    <div class="bg-gray-100 p-5 rounded-lg mb-6">
        <p class="mb-2"><strong>Category:</strong> <?php echo CHtml::encode($category->name); ?></p>
        <p class="mb-2"><strong>Service:</strong> <?php echo CHtml::encode($service->name); ?> <span class="text-blue-600">(₹<?php echo number_format($service->price, 2); ?>)</span></p>
        <p class="mb-2"><strong>Staff:</strong> <?php echo CHtml::encode($staff->user->name); ?></p>
        <p class="mb-2"><strong>Date & Time:</strong> <?php echo CHtml::encode($date); ?> at <?php echo CHtml::encode($time); ?></p>
    </div>

    <!-- Confirmation Form -->
    <form method="post" action="<?php echo $this->createUrl('appointment/confirm'); ?>">
        <?php echo CHtml::hiddenField('category_id', $category->id); ?>
        <?php echo CHtml::hiddenField('service_id', $service->id); ?>
        <?php echo CHtml::hiddenField('staff_id', $staff->user_id); ?>
        <?php echo CHtml::hiddenField('appointment_date', $date); ?>
        <?php echo CHtml::hiddenField('appointment_time', $time); ?>

        <!-- Notes -->
        <div class="mb-6">
            <label for="notes" class="block font-medium mb-2">Additional Notes (Optional):</label>
            <textarea name="notes" id="notes" rows="4" class="w-full border border-gray-300 rounded px-4 py-2 resize-none focus:ring focus:ring-blue-200" placeholder="Enter any special instructions..."></textarea>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                Confirm Booking
            </button>
        </div>
    </form>
</div>

<div class="max-w-3xl mx-auto my-8 p-6 bg-white shadow rounded" style="display: none;;">
    <h2 class="text-xl font-semibold mb-4">Confirm Your Booking</h2>
    <div class="bg-gray-100 p-4 rounded">
        <p><strong>Category:</strong> <?php echo CHtml::encode($category->name); ?></p>
        <p><strong>Service:</strong> <?php echo CHtml::encode($service->name); ?> (₹<?php echo number_format($service->price, 2); ?>)</p>
        <p><strong>Staff:</strong> <?php echo CHtml::encode($staff->user->name); ?></p>
        <p><strong>Date & Time:</strong> <?php echo CHtml::encode($date); ?> at <?php echo CHtml::encode($time); ?></p>
    </div>

    <form method="post" action="<?php echo $this->createUrl('appointment/confirm'); ?>">
        <!-- hidden inputs to carry over the data -->
        <?php echo CHtml::hiddenField('category_id', $category->id); ?>
        <?php echo CHtml::hiddenField('service_id', $service->id); ?>
        <?php echo CHtml::hiddenField('staff_id', $staff->user_id); ?>
        <?php echo CHtml::hiddenField('appointment_date', $date); ?>
        <?php echo CHtml::hiddenField('appointment_time', $time); ?>

         <div class="mt-4">
            <label for="notes" class="block font-medium mb-2">Additional Notes (Optional):</label>
            <textarea name="notes" id="notes" rows="4" class="w-full border rounded px-3 py-2" placeholder=""></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mt-4">
            Confirm Booking
        </button>
    </form>
</div>
