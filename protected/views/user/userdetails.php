<div class="max-w-5xl mx-auto mt-6 p-6 bg-white rounded-lg shadow-md">
    <!-- User Info -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            <?= $user->role === 'employee' ? 'Appointments Assigned to Employee' : 'Appointments Booked by Customer' ?>
        </h2>
        <p class="text-gray-600"><strong>User Name:</strong> <?= CHtml::encode($user->name) ?></p>
        <p class="text-gray-600"><strong>User Email:</strong> <?= CHtml::encode($user->email) ?></p>
    </div>

    <!-- Appointment Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 font-medium text-gray-700">ID</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Category</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Service</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Appointment Date</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Appointment Time</th>
                    
                    <?php if ($user->role === 'employee'): ?>
                        <th class="px-6 py-3 font-medium text-gray-700">Booked By</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($appointments as $appointment): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-800"><?= CHtml::encode($appointment->id) ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= CHtml::encode($appointment->category->name) ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= CHtml::encode($appointment->service->name) ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= CHtml::encode($appointment->appointment_date) ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= CHtml::encode($appointment->appointment_time) ?></td>

                        <?php if ($user->role === 'employee'): ?>
                            <td class="px-6 py-4 text-gray-800">
                                <?= CHtml::encode($appointment->user->name) ?> <br>
                                <span class="text-sm text-gray-500"><?= CHtml::encode($appointment->user->email) ?></span>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- <h2>User Appointment Details</h2> -->

<!-- User Info -->
<!-- <p><strong>User Name:</strong> <?= CHtml::encode($user->name) ?></p> -->
<!-- <p><strong>User Email:</strong> <?= CHtml::encode($user->email) ?></p> -->

<!-- Appointment Table -->
<table class="table-auto w-full" style="display: none;">
    <thead>
        <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Service</th>
            <th class="px-4 py-2 text-left">Appointment Date</th>
            <th class="px-4 py-2 text-left">Appointment Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td class="border px-4 py-2"><?= CHtml::encode($appointment->id) ?></td>
                <td class="border px-4 py-2"><?= CHtml::encode($appointment->category->name) ?></td>
                <td class="border px-4 py-2"><?= CHtml::encode($appointment->service->name) ?></td>
                <td class="border px-4 py-2"><?= CHtml::encode($appointment->appointment_date) ?></td>
                <td class="border px-4 py-2"><?= CHtml::encode($appointment->appointment_time) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
