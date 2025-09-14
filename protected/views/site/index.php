<section class="bg-gray-50">
	<div class="max-w-7xl mx-auto px-4 py-20 text-center">
		<h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Appointment Booking System</h1>
		<p class="text-gray-600 text-lg mb-8">
			Easily manage your company's employees, departments, and designations.
		</p>
		<!-- <a href="#" class="inline-block px-6 py-3 text-white bg-cyan-600 rounded-md hover:bg-cyan-700 transition">Get Started</a> -->
	</div>
</section>


<section class="bg-white py-16">
	<div class="max-w-6xl mx-auto px-4">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
			<div class="text-center">
				<div class="text-cyan-600 text-4xl mb-2">👨‍💼</div>
				<h3 class="text-lg font-semibold mb-2">Manage Employees</h3>
				<p class="text-gray-600">Add, update, and track all employee records.</p>
			</div>
			<div class="text-center">
				<div class="text-cyan-600 text-4xl mb-2">🏢</div>
				<h3 class="text-lg font-semibold mb-2">Departments</h3>
				<p class="text-gray-600">Organize employees by department and designation.</p>
			</div>
			<div class="text-center">
				<a href="<?php echo Yii::app()->createUrl('appointment/step1'); ?>" class="flex flex-col items-center p-4 border rounded hover:bg-blue-50 transition">
					<div class="text-cyan-600 text-4xl mb-2">📅</div>
					<h3 class="text-lg font-semibold mb-2">Book Appointment</h3>
					<p class="text-gray-600">Start scheduling appointments with just a few steps.</p>
				</a>
			</div>
		</div>
	</div>
</section>