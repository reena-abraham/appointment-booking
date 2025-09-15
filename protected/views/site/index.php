<!-- Hero Section -->
<section class="bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 py-24 text-center">
    <h1 class="text-5xl font-extrabold text-gray-900 mb-6">Simplify Your Appointment Scheduling</h1>
    <p class="text-gray-600 text-xl max-w-2xl mx-auto mb-10">
      Manage appointments, clients, and services effortlessly with our all-in-one booking system.
    </p>
    <a href="<?php echo Yii::app()->createUrl('appointment/step1'); ?>" 
       class="inline-block px-8 py-4 text-white bg-cyan-600 rounded-md shadow hover:bg-cyan-700 transition-all duration-300">
      Book an Appointment
    </a>
  </div>
</section>

<!-- Features Section -->
<section class="bg-white py-20">
  <div class="max-w-6xl mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      
      <!-- Feature 1 -->
      <div class="text-center hover:shadow-lg rounded-lg p-6 transition-all duration-300">
        <div class="text-cyan-600 text-5xl mb-4">📋</div>
        <h3 class="text-xl font-semibold mb-2">Manage Appointments</h3>
        <p class="text-gray-600">Create, update, and track appointments with a simple and intuitive interface.</p>
      </div>

      <!-- Feature 2 -->
      <div class="text-center hover:shadow-lg rounded-lg p-6 transition-all duration-300">
        <div class="text-cyan-600 text-5xl mb-4">👥</div>
        <h3 class="text-xl font-semibold mb-2">Client Management</h3>
        <p class="text-gray-600">Maintain a database of clients, view booking history, and streamline communications.</p>
      </div>

      <!-- Feature 3 -->
      <a href="<?php echo Yii::app()->createUrl('appointment/step1'); ?>" 
         class="text-center border border-cyan-100 hover:shadow-lg rounded-lg p-6 transition-all duration-300 block hover:bg-blue-50">
        <div class="text-cyan-600 text-5xl mb-4">⚙️</div>
        <h3 class="text-xl font-semibold mb-2">Service Configuration</h3>
        <p class="text-gray-600">Customize available services, duration, and availability based on staff schedules.</p>
      </a>

    </div>
  </div>
</section>

<section class="bg-gray-50" style="display:none;">
	<div class="max-w-7xl mx-auto px-4 py-20 text-center">
		<h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Appointment Booking System</h1>
		<p class="text-gray-600 text-lg mb-8">
			Easily manage your company's employees, departments, and designations.
		</p>
		<!-- <a href="#" class="inline-block px-6 py-3 text-white bg-cyan-600 rounded-md hover:bg-cyan-700 transition">Get Started</a> -->
	</div>
</section>


<section class="bg-white py-16" style="display: none;">
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