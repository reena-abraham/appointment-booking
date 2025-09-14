<div class="w-full max-w-4xl mx-auto mt-12">
    <!-- Tabs -->
    <div class="border-b border-gray-300">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button
                id="tab-upcoming"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm focus:outline-none border-indigo-600 text-indigo-700 transition"
                aria-current="page"
                onclick="openTab('upcoming')">
                Upcoming Appointments
            </button>

            <button
                id="tab-past"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition"
                onclick="openTab('past')">
                Past Appointments
            </button>
        </nav>
    </div>

    <!-- Upcoming Appointments -->
    <div id="tab-content-upcoming" class="pt-8">
        <?php if (!empty($upcomingAppointments)): ?>
            <?php foreach ($upcomingAppointments as $appointment): ?>
                <div class="w-full bg-white border border-indigo-100 rounded-lg shadow-sm hover:shadow-md p-6 mb-5 transition duration-300">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div>
                            <h3 class="text-lg font-bold text-indigo-800 mb-2">
                                <?php echo CHtml::encode($appointment->category->name); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-1">
                                📅 <span class="font-medium">Date:</span> <?php echo CHtml::encode($appointment->appointment_date); ?>
                            </p>
                            <p class="text-sm text-gray-600 mb-1">
                                ⏰ <span class="font-medium">Time:</span>
                                <?php
                                $start = new DateTime($appointment->appointment_time);
                                $end = new DateTime($appointment->appointment_time);
                                $duration = !empty($appointment->duration_minutes) ? (int)$appointment->duration_minutes : 15;
                                $end->modify("+{$duration} minutes");
                                // $end->modify('+' . (int)$appointment->duration_minutes . ' minutes');
                                $time = $start->format('H:i') . ' - ' . $end->format('H:i');
                                echo CHtml::encode($time);
                                ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                🧑‍⚕️ <span class="font-medium">Staff:</span> <?php echo CHtml::encode($appointment->staff->user->name); ?>
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <!-- <a href="#" class="inline-block px-4 py-2 text-sm text-white bg-red-600 hover:bg-indigo-700 rounded-md transition">
                                Cancel
                            </a> -->
                            <!-- <a href="#"
                                class="cancel-btn inline-block px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md transition"
                                data-url="<?= $this->createUrl('appointment/cancel', ['id' => $appointment->id]) ?>" data-id="<?= $appointment->id ?>">
                                Cancel
                            </a> -->
                            <?php if ($appointment->status === 'pending'): ?>
                                <a href="#"
                                    class="cancel-btn inline-block px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md transition"
                                    data-url="<?= $this->createUrl('appointment/cancel', ['id' => $appointment->id]) ?>">
                                    Cancel
                                </a>
                            <?php elseif ($appointment->status === 'cancelled'): ?>
                                <span class="inline-block px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-md">
                                    Cancelled
                                </span>
                            <?php elseif ($appointment->status === 'confirmed'): ?>
                                <span class="inline-block px-4 py-2 text-sm font-medium text-cyan-600 border border-cyan-600 rounded-md">
                                    Confirmed
                                </span>
                            <?php elseif ($appointment->status === 'completed'): ?>
                                <span class="inline-block px-4 py-2 text-sm font-medium text-green-600 border border-green-600 rounded-md">
                                    Completed
                                </span>
                            <?php endif; ?>


                            <!-- Cancel Confirmation Modal -->
                            <div id="cancelModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Cancel Appointment</h3>
                                    <p class="text-gray-600 mb-6 text-sm">Are you sure you want to cancel this appointment?</p>
                                    <div class="flex justify-end space-x-3">
                                        <button id="cancelNoBtn" class="text-gray-500 hover:text-gray-700 text-sm">No</button>
                                        <a id="confirmCancelBtn" href="#" class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                            Yes, Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 text-sm text-center">You have no upcoming appointments.</p>
        <?php endif; ?>
    </div>

    <!-- Past Appointments -->
    <div id="tab-content-past" class="hidden pt-8">
        <?php if (!empty($pastAppointments)): ?>
            <?php foreach ($pastAppointments as $appointment): ?>
                <div class="w-full bg-gray-50 border border-gray-200 rounded-lg shadow-sm p-6 mb-5">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                <?php echo CHtml::encode($appointment->category->name); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-1">
                                📅 <span class="font-medium">Date:</span> <?php echo CHtml::encode($appointment->appointment_date); ?>
                            </p>
                            <p class="text-sm text-gray-600 mb-1">
                                ⏰ <span class="font-medium">Time:</span>
                                <?php
                                $start = new DateTime($appointment->appointment_time);
                                $end = new DateTime($appointment->appointment_time);
                                $duration = !empty($appointment->duration_minutes) ? (int)$appointment->duration_minutes : 15;
                                $end->modify("+{$duration} minutes");
                                // $end->modify('+' . (int)$appointment->duration_minutes . ' minutes');
                                $time = $start->format('H:i') . ' - ' . $end->format('H:i');
                                echo CHtml::encode($time);
                                ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                🧑‍⚕️ <span class="font-medium">Doctor:</span> <?php echo CHtml::encode($appointment->staff->user->name); ?>
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <a href="#" class="inline-block px-4 py-2 text-sm text-indigo-700 border border-indigo-600 hover:bg-indigo-50 rounded-md transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 text-sm text-center">You have no past appointments.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Tab Switcher -->
<script>
    function openTab(tabName) {
        const tabs = ['upcoming', 'past'];

        tabs.forEach(name => {
            const tabButton = document.getElementById('tab-' + name);
            const tabContent = document.getElementById('tab-content-' + name);

            if (name === tabName) {
                tabButton.classList.add('border-indigo-600', 'text-indigo-700');
                tabButton.classList.remove('border-transparent', 'text-gray-500');
                tabContent.classList.remove('hidden');
            } else {
                tabButton.classList.remove('border-indigo-600', 'text-indigo-700');
                tabButton.classList.add('border-transparent', 'text-gray-500');
                tabContent.classList.add('hidden');
            }
        });
    }
</script>

<div class="w-full max-w-4xl mx-auto mt-8" style="display: none;">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button
                id="tab-upcoming"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-indigo-500 text-indigo-600"
                aria-current="page"
                onclick="openTab('upcoming')">
                Upcoming Appointments
            </button>

            <button
                id="tab-past"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                onclick="openTab('past')">
                Past Appointments
            </button>
        </nav>
    </div>

    <!-- Upcoming Appointments -->
    <div id="tab-content-upcoming" class="pt-6">
        <?php if (!empty($upcomingAppointments)): ?>
            <?php foreach ($upcomingAppointments as $appointment): ?>
                <div class="max-w-2xl w-full bg-white border border-gray-200 rounded-lg shadow p-5 mb-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                <?php echo CHtml::encode($appointment->category->name); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-1">
                                <span class="font-medium">Date:</span> <?php echo CHtml::encode($appointment->appointment_date); ?>
                            </p>
                            <p class="text-sm text-gray-600 mb-1">
                                <?php
                                $start = new DateTime($appointment->appointment_time);
                                $end = new DateTime($appointment->appointment_time);
                                $end->modify('+' . (int)$appointment->duration_minutes . ' minutes');

                                $time = $start->format('H:i') . ' - ' . $end->format('H:i');
                                ?>
                                <span class="font-medium">Time:</span> <?php echo CHtml::encode($time); ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Doctor:</span> <?php echo CHtml::encode($appointment->staff->user->name); ?>
                            </p>
                        </div>
                        <!-- Optional Action Button -->

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 text-sm">No upcoming appointments.</p>
        <?php endif; ?>


    </div>

    <!-- Past Appointments -->
    <div id="tab-content-past" class="hidden pt-6">
        <?php if (!empty($pastAppointments)): ?>
            <?php foreach ($pastAppointments as $appointment): ?>
                <div class="max-w-2xl w-full bg-white border border-gray-200 rounded-lg shadow p-5 mb-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                <?php echo CHtml::encode($appointment->category->name); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-1">
                                <span class="font-medium">Date:</span> <?php echo CHtml::encode($appointment->appointment_date); ?>
                            </p>
                            <p class="text-sm text-gray-600 mb-1">
                                <?php
                                $start = new DateTime($appointment->appointment_time);
                                $end = new DateTime($appointment->appointment_time);
                                $end->modify('+' . (int)$appointment->duration_minutes . ' minutes');

                                $time = $start->format('H:i') . ' - ' . $end->format('H:i');
                                ?>
                                <span class="font-medium">Time:</span> <?php echo CHtml::encode($time); ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Doctor:</span> <?php echo CHtml::encode($appointment->staff->user->name); ?>
                            </p>
                        </div>
                        <!-- Optional Action Button -->
                        <div class="mt-4 sm:mt-0">
                            <a href="#" class="inline-block px-4 py-2 text-sm text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500 text-sm">No past appointments.</p>
        <?php endif; ?>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.cancel-btn').on('click', function(e) {
            e.preventDefault();
            const cancelUrl = $(this).data('url');

            $('#confirmCancelBtn').attr('href', cancelUrl);
            $('#cancelModal').removeClass('hidden');
        });

        $('#cancelNoBtn').on('click', function() {
            $('#cancelModal').addClass('hidden');
        });
    });
</script>