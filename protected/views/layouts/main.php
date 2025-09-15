<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Appointment Booking | Homepage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Tailwind CSS via CDN -->
	<script src="https://cdn.tailwindcss.com"></script>
	<!-- Windster (optional if using JS features) -->
	<script src="https://unpkg.com/flowbite@1.6.4/dist/flowbite.js"></script>
</head>

<body class="bg-white text-gray-800">

	<nav class="bg-white border-b border-gray-200 px-4 py-3 shadow-sm">
		<div class="flex items-center justify-between max-w-7xl mx-auto">
			<div class="flex items-center space-x-2">
				<img src="https://themewagon.github.io/windster/images/logo.svg" class="h-6 mr-2" alt="Windster Logo">
				<span class="text-xl font-semibold text-cyan-600">Appointment Booking</span>
			</div>
			<div class="flex items-center space-x-4">
				<a href="<?php echo Yii::app()->createUrl('site/index'); ?>" class="text-gray-600 hover:text-cyan-600">Home</a>
				<?php if (Yii::app()->user->isGuest): ?>
					<a href="<?php echo Yii::app()->createUrl('site/login'); ?>" class="text-gray-600 hover:text-cyan-600">Login</a>
					<a href="<?php echo Yii::app()->createUrl('site/register'); ?>" class="text-gray-600 hover:text-cyan-600">Register</a>

				<?php else: ?>
					<?php $user = User::model()->findByPk(Yii::app()->user->id); ?>
					<div class="relative ml-3">
						<button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-cyan-600" id="user-menu-button" onclick="toggleUserMenu()">
						  <?php if (!empty($user->profile_picture)): ?>
						<img class="w-24 h-24 rounded-full object-cover border"
								   src="<?php echo Yii::app()->baseUrl . '/uploads/user/' . CHtml::encode($user->profile_picture); ?>"
								alt="Profile" style="width: 45px !important; height: 45px !important;max-width: 100%; height: auto;">	
						  <?php else: ?>
							<img class="w-24 h-24 rounded-full object-cover border"
								  src="<?php echo Yii::app()->baseUrl . '/images/user.png'; ?>"
								alt="Profile" style="width: 45px !important; height: 45px !important;max-width: 100%; height: auto;">	
							 <?php endif; ?>
								<!-- <img class="w-24 h-24 rounded-full object-cover border"
								src="<?php echo Yii::app()->createUrl('site/profilePicture', array('id' => $user->id)); ?>"
								alt="Profile" style="width: 45px !important; height: 45px !important;max-width: 100%; height: auto;"> -->

							<span class="ml-2 font-medium text-gray-900"><?php echo CHtml::encode($user->name); ?></span>
							<svg class="w-4 h-4 ml-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
							</svg>
						</button>

						<div id="userDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
							<div class="px-4 py-3 border-b border-gray-100">
								<p class="text-sm font-medium text-gray-900"><?php echo CHtml::encode($user->name); ?></p>
								<p class="text-sm text-gray-500 truncate"><?php echo CHtml::encode($user->email); ?></p>
							</div>
							<ul class="py-2">
								<li><a href="<?php echo Yii::app()->createUrl('site/profile'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit profile</a></li>
								<li><a href="<?php echo Yii::app()->createUrl('site/myAppointments'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Appointments</a></li>

								<li>
									<hr class="my-2 border-t border-gray-200">
								</li>
								<li><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a></li>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</nav>

	<?php echo $content; ?>


	<footer class="bg-gray-100 text-gray-600 py-6 text-center">
		<p>&copy; <?php echo date('Y'); ?> Appointment Booking</p>
	</footer>

	<?php
	Yii::app()->clientScript->registerCoreScript('jquery');
	?>
	<script>
		function toggleUserMenu() {
                                const dropdown = document.getElementById('userDropdown');
                                dropdown.classList.toggle('hidden');
                            }

                            // Optional: close menu when clicking outside
                            document.addEventListener('click', function(event) {
                                const menuButton = document.getElementById('user-menu-button');
                                const menu = document.getElementById('userDropdown');
                                if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                                    menu.classList.add('hidden');
                                }
                            });
		// function toggleUserMenu() {
		// 	$('#userDropdown').toggleClass('hidden');
		// }

		// $(document).ready(function() {
		// 	// Toggle user menu
		// 	$('#user-menu-button').on('click', function(event) {
		// 		event.stopPropagation(); // Prevent event bubbling
		// 		$('#userDropdown').toggleClass('hidden');
		// 	});

		// 	// Hide user menu when clicking outside
		// 	$(document).on('click', function(event) {
		// 		const menuButton = $('#user-menu-button');
		// 		const menu = $('#userDropdown');
		// 		if (!menu.is(event.target) && menu.has(event.target).length === 0 &&
		// 			!menuButton.is(event.target) && menuButton.has(event.target).length === 0) {
		// 			menu.addClass('hidden');
		// 		}
		// 	});

		// });

		
	</script>

</body>

</html>