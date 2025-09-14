
<div class="max-w-3xl mx-auto my-12 p-8 bg-white shadow-2xl rounded-lg border border-gray-200">
    <!-- Success Heading -->
    <div class="text-center mb-6">
        <div class="flex justify-center items-center mb-4">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-green-700">Booking Confirmed!</h2>
        <p class="text-gray-600 mt-2">Thank you for your appointment. Here are your booking details:</p>
    </div>

    <!-- Booking Details -->
    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-inner">
        <dl class="space-y-4">
            <div class="grid grid-cols-2">
                <dt class="font-semibold text-gray-700">Category:</dt>
                <dd class="text-gray-800"><?php echo CHtml::encode($appointment->category->name); ?></dd>
            </div>

            <div class="grid grid-cols-2">
                <dt class="font-semibold text-gray-700">Service:</dt>
                <dd class="text-gray-800">
                    <?php echo CHtml::encode($appointment->service->name); ?> 
                    <span class="text-blue-600 font-semibold">(₹<?php echo CHtml::encode($appointment->service->price); ?>)</span>
                </dd>
            </div>

            <div class="grid grid-cols-2">
                <dt class="font-semibold text-gray-700">Staff:</dt>
                <dd class="text-gray-800"><?php echo CHtml::encode($appointment->staff->user->name); ?></dd>
            </div>

            <div class="grid grid-cols-2">
                <dt class="font-semibold text-gray-700">Date & Time:</dt>
                <dd class="text-gray-800"><?php echo CHtml::encode($appointment->appointment_date); ?> at <?php echo CHtml::encode($appointment->appointment_time); ?></dd>
            </div>

            <?php if (!empty($appointment->notes)): ?>
                <div class="grid grid-cols-2">
                    <dt class="font-semibold text-gray-700">Notes:</dt>
                    <dd class="text-gray-800"><?php echo CHtml::encode($appointment->notes); ?></dd>
                </div>
            <?php endif; ?>
        </dl>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 text-center">
        <a href="<?php echo $this->createUrl('site/index'); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded shadow transition">
            Back to Home
        </a>
        <a href="<?php echo $this->createUrl('site/myappointments'); ?>" class="inline-block ml-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold px-6 py-3 rounded border border-gray-300 transition">
            View My Appointments
        </a>
    </div>
</div>



<div class="max-w-3xl mx-auto my-8 p-6 bg-white shadow rounded" style="display:none;">
    <h2>Booking Successful!</h2>

    <div class="bg-gray-100 p-4 rounded mt-4">
        <p><strong>Category:</strong> <?php echo CHtml::encode($appointment->category->name); ?></p>
        <p><strong>Service:</strong> <?php echo CHtml::encode($appointment->service->name); ?> (₹<?php echo CHtml::encode($appointment->service->price); ?>)</p>
        <p><strong>Staff:</strong> <?php echo CHtml::encode($appointment->staff->user->name); ?></p>
        <p><strong>Date & Time:</strong> <?php echo CHtml::encode($appointment->appointment_date); ?> at <?php echo CHtml::encode($appointment->appointment_time); ?></p>

        <?php if (!empty($appointment->notes)): ?>
            <p><strong>Notes:</strong> <?php echo CHtml::encode($appointment->notes); ?></p>
        <?php endif; ?>
    </div>
</div>
