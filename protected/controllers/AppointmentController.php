<?php
class AppointmentController extends Controller
{
    public function filters()
    {
        return [
            'accessControl', // perform access control for CRUD operations
        ];
    }
    public function accessRules()
    {
        return [
            // Allow only authenticated users with role 'customer'
            [
                'allow',
                'actions' => ['step1', 'step2', 'step3', 'step4', 'step5', 'confirm', 'success', 'getAvailabilitySlots', 'cancel'], // add all relevant actions
                'users' => ['@'], // '@' means authenticated users
                'expression' => 'Yii::app()->user->getState("role") === "customer"', // custom condition
            ],

            // Deny all other users
            [
                'deny',
                'users' => ['*'], // '*' means all users
            ],
        ];
    }


    public function actionStep1()
    {
        $categories = Category::model()->findAll();
        $this->render('step1', ['categories' => $categories]);
    }
    public function actionStep2()
    {
        if (isset($_POST['category'])) {
            Yii::app()->session['category'] = $_POST['category'];
        }
        $categoryId = Yii::app()->session['category'];
        $services = ServiceType::model()->findAllByAttributes(['category_id' => $categoryId]);
        $this->render('step2', ['services' => $services]);
    }
    public function actionStep3()
    {
        // if (isset($_POST['service'])) {
        //     Yii::app()->session['service'] = $_POST['service'];
        // }
        // $staff = Employee::model()->findAll(); // or filter by service     
        // $this->render('step3', ['staff' => $staff]);

        // Save selected service to session if POSTed
        if (isset($_POST['service'])) {
            Yii::app()->session['service'] = $_POST['service'];
        }

        $serviceId = Yii::app()->session['service'] ?? null;

        // Redirect back if service not set
        if (!$serviceId) {
            $this->redirect(['appointment/step2']);
            return;
        }

        $service = ServiceType::model()->findByPk($serviceId);
        $categoryId = $service->category_id ?? null;
        // print_r($categoryId);exit;
        // Fetch staff - optionally filter by service if you have that relationship
        //$staff = Employee::model()->findAll();  // Customize this query if needed

        $staff = Employee::model()->with('services', 'category')->findAll(
            't.category_id = :category_id AND EXISTS (SELECT 1 FROM employee_services es WHERE es.service_id = :service_id AND es.employee_id = t.user_id)',
            [
                ':category_id' => $categoryId,
                ':service_id' => $serviceId,
            ]
        );
        // print_r($categoryId);exit;
        //  $staff = Yii::app()->db->createCommand()
        // ->select('e.id, e.user_id, e.category_id')
        // ->from('employee e')
        // ->join('employee_services es', 'es.employee_id = e.user_id')
        // ->where('e.category_id = :category_id AND es.service_id = :service_id', [
        //     ':category_id' => $categoryId,
        //     ':service_id' => $serviceId,
        // ])
        // ->queryAll();
        // print_r($staff);exit;
        // Render view and pass staff data
        $this->render('step3', ['staff' => $staff]);
    }
    public function actionStep4($staff_id = null)
    {
        // print_r('f');exit;
        // Get category and service IDs from session
        $categoryId = Yii::app()->session->get('category');
        $serviceId = Yii::app()->session->get('service');

        // If staff_id not passed via URL param, get from POST (form submission)
        if (!$staff_id) {
            $staff_id = Yii::app()->request->getPost('staff');
        }

        if (!$staff_id) {
            throw new CHttpException(400, 'Staff ID is required.');
        }

        // Load employee record by user_id (staff id)
        $employee = Employee::model()->find('user_id=:uid', [':uid' => $staff_id]);
        if (!$employee) {
            throw new CHttpException(404, 'Staff member not found.');
        }

        $category = Category::model()->findByPk($categoryId);
        $service = ServiceType::model()->findByPk($serviceId);

        $this->render('step4', [
            'employee' => $employee,
            'category' => $category,
            'service' => $service,
            'staff_id' => $staff_id,
        ]);
    }
    public function actionStep5()
    {
        // Get data from POST or session
        $categoryId = Yii::app()->request->getPost('category_id', Yii::app()->session->get('category'));
        $serviceId = Yii::app()->request->getPost('service_id', Yii::app()->session->get('service'));
        $staffId = Yii::app()->request->getPost('staff_id');
        $date = Yii::app()->request->getPost('selected_date');
        $time = Yii::app()->request->getPost('selected_slot');

        if (!$categoryId || !$serviceId || !$staffId || !$date || !$time) {
            throw new CHttpException(400, 'Missing required booking information.');
        }

        $category = Category::model()->findByPk($categoryId);
        $service = ServiceType::model()->findByPk($serviceId);
        $staff = Employee::model()->find('user_id=:uid', [':uid' => $staffId]);

        if (!$staff) {
            throw new CHttpException(404, 'Staff member not found.');
        }

        // Pass all variables to the view
        $this->render('step5', [
            'category' => $category,
            'service' => $service,
            'staff' => $staff,
            'date' => $date,
            'time' => $time,
        ]);
    }
    public function actionConfirm()
    {
        $model = new Appointment;
        $model->attributes = $_POST;
        $model->user_id = Yii::app()->user->id;
        $service = ServiceType::model()->findByPk($model->service_id);
        $model->price = $service->price;
        $settings = EmployeeSettings::model()->findByAttributes(['employee_id' => $model->staff_id]);
        $model->duration_minutes = $settings ? (int)$settings->service_duration : 15; // default to 15 mins if not set
        if ($model->save()) {
            $this->redirect(['appointment/success', 'id' => $model->id]);
        } else {
            print_r($model->getErrors());
        }
    }

    public function actionSuccess($id)
    {
        $appointment = Appointment::model()->findByPk($id);
        // print_r($appointment);exit;
        $this->render('success', ['appointment' => $appointment]);
    }
    public function actionGetAvailabilitySlots()
    {
        header('Content-Type: application/json');

        $staffId = isset($_GET['staff_id']) ? (int)$_GET['staff_id'] : null;
        $date = isset($_GET['date']) ? $_GET['date'] : null;
        // print_r($staffId);
        // print_r($date);exit;
        if (!$staffId || !$date) {
            echo CJSON::encode(['error' => 'Missing staff_id or date']);
            Yii::app()->end();
        }

        $weekday = strtolower(date('l', strtotime($date))); // e.g. "monday"

        // Fetch availability for employee and day
        $availability = EmployeeAvailability::model()->getByStaffAndDay($staffId, $weekday);

        if (!$availability || empty($availability->slots)) {
            echo CJSON::encode(['slots' => []]);
            Yii::app()->end();
        }

        $employeeSetting = EmployeeSettings::model()->find('employee_id = :employee_id', [
            ':employee_id' => $staffId,
        ]);
        $slotDuration = isset($employeeSetting) ? (int)$employeeSetting->service_duration : 30;


        $bookedSlots = Appointment::model()->findAll([
            'condition' => 'staff_id = :staff_id AND appointment_date = :date AND status IN (:pending, :confirmed)',
            'params' => [':staff_id' => $staffId, ':date' => $date, ':pending' => 'pending', ':confirmed' => 'confirmed',],
        ]);
        $bookedTimes = [];
        foreach ($bookedSlots as $appointment) {
            $bookedTimes[] = $appointment->appointment_time;
        }

        $slots = [];

        foreach ($availability->slots as $slot) {
            $start = new DateTime($slot->from_time);
            $end = new DateTime($slot->to_time);

            // Generate 30-minute slots with optional 10-minute breaks
            while ($start < $end) {
                $slotEnd = clone $start;
                $slotEnd->modify("+{$slotDuration} minutes");

                if ($slotEnd > $end) break;
                // print_r($start->format('H:i'));
                // print_r($bookedTimes);
                // exit;
                // print_r($bookedTimes);exit;
                // $isBooked = in_array($start->format('H:i'), $bookedTimes);
                $isBooked = in_array($start->format('H:i:s'), array_map(function ($time) {
                    return date('H:i:s', strtotime($time)); // Convert to H:i:s format
                }, $bookedTimes));

                // $slots[] = $start->format('H:i') . ' - ' . $slotEnd->format('H:i');
                $slots[] = [
                    'time' => $start->format('H:i') . ' - ' . $slotEnd->format('H:i'),
                    'isBooked' => $isBooked, // true if the slot is booked
                ];
                $start->modify("+{$slotDuration} minutes");
            }
        }

        echo CJSON::encode(['slots' => $slots]);
        Yii::app()->end();
    }

    public function actionCancel($id)
    {
        $appointment = Appointment::model()->findByPk($id);

        if (!$appointment || $appointment->user_id !== Yii::app()->user->id) {
            throw new CHttpException(403, 'Unauthorized.');
        }

        $appointment->status = 'cancelled';
        if ($appointment->save()) {
            Yii::app()->user->setFlash('success', 'Appointment cancelled successfully.');
        } else {
            Yii::app()->user->setFlash('error', 'Failed to cancel appointment.');
        }

        $this->redirect(['site/myappointments']);
    }





    // public function actionStep2($category)
    // {
    //     if (isset($_POST['category'])) {
    //         Yii::app()->session['category'] = $_POST['category'];
    //     }
    //     $categoryId = Yii::app()->session['category'];
    //     $services = ServiceType::model()->findAllByAttributes(['category_id' => $category]);
    //     $this->render('step2', ['services' => $services]);
    // }

    // public function actionStep3($service)
    // {
    //     if (isset($_POST['service'])) {
    //         Yii::app()->session['service'] = $_POST['service'];
    //     }
    //     $staff = Employee::model()->findAll(); // or filter by service     
    //     $this->render('step3', ['staff' => $staff]);
    // }
    // public function actionStep4()
    // {
    //     if (!isset($_GET['staff'])) {
    //         throw new CHttpException(400, 'Staff member not specified.');
    //     }

    //     $userId = (int) $_GET['staff'];

    //     // Get employee record
    //     $employee = Employee::model()->find('user_id = :uid', [':uid' => $userId]);

    //     if (!$employee) {
    //         throw new CHttpException(404, 'Staff not found.');
    //     }

    //     $slots = [];

    //     if (isset($_POST['date'])) {
    //         $selectedDate = $_POST['date']; // format: yyyy-mm-dd
    //         $dayOfWeek = strtolower(date('l', strtotime($selectedDate))); // e.g., 'thursday'

    //         // Check if employee is available on this day
    //         $availability = EmployeeAvailability::model()->findByAttributes([
    //             'employee_id' => $employee->id,
    //             'day' => $dayOfWeek,
    //             'enabled' => 1
    //         ]);

    //         if ($availability) {
    //             // Get all time slots for this availability
    //             $slots = EmployeeAvailabilitySlot::model()->findAllByAttributes([
    //                 'availability_id' => $availability->id
    //             ]);
    //         }
    //     }

    //     $this->render('step4', [
    //         'employee' => $employee,
    //         'slots' => $slots,
    //         'staffId' => $userId,
    //     ]);
    // }
    // public function actionStep4()
    // {
    //     // Get staff ID from POST first, fallback to GET
    //     if (isset($_POST['staff_id'])) {
    //         Yii::app()->session['staff_id'] = $_POST['staff_id'];
    //     }
    //     $staffId = isset($_POST['staff_id']) ? (int)$_POST['staff_id'] : (isset($_GET['staff']) ? (int)$_GET['staff'] : null);
    //     $categoryId = $_POST['category_id'] ?? null;
    //     $serviceId = $_POST['service_id'] ?? null;

    //     if (!$staffId) {
    //         throw new CHttpException(400, 'Staff member not specified.');
    //     }

    //     // Get employee record
    //     $employee = Employee::model()->find('user_id = :uid', [':uid' => $staffId]);

    //     if (!$employee) {
    //         throw new CHttpException(404, 'Staff not found.');
    //     }

    //     $slots = [];

    //     if (isset($_POST['date'])) {
    //         $selectedDate = $_POST['date']; // format: yyyy-mm-dd
    //         $dayOfWeek = strtolower(date('l', strtotime($selectedDate))); // e.g., 'thursday'

    //         // Check if employee is available on this day
    //         $availability = EmployeeAvailability::model()->findByAttributes([
    //             'employee_id' => $employee->id,
    //             'day' => $dayOfWeek,
    //             'enabled' => 1
    //         ]);

    //         if ($availability) {
    //             // Get all time slots for this availability
    //             $slots = EmployeeAvailabilitySlot::model()->findAllByAttributes([
    //                 'availability_id' => $availability->id
    //             ]);
    //         }
    //     }

    //     $this->render('step4', [
    //         'employee' => $employee,
    //         'slots' => $slots,
    //         'staffId' => $staffId,
    //         'categoryId' => $categoryId,
    //         'serviceId' => $serviceId,
    //     ]);
    // }
    //  public function actionStep4($staff_id = null)
    // {
    //     // Retrieve category_id and service_id from session (adjust if you store differently)
    //     $categoryId = Yii::app()->session->get('category_id');
    //     $serviceId = Yii::app()->session->get('service_id');

    //     // If staff_id not provided via URL param, try to get it from POST data
    //     if (!$staff_id) {
    //         $staff_id = Yii::app()->request->getPost('staff'); // matches your form input name="staff"
    //     }

    //     // If still no staff_id, throw error
    //     if (!$staff_id) {
    //         throw new CHttpException(400, 'Staff ID is required.');
    //     }

    //     // Find the employee by primary key
    //     // $employee = Employee::model()->findByPk($staff_id);
    //     $employee = Employee::model()->find('user_id=:uid', [':uid' => $staff_id]);

    //     if (!$employee) {
    //         throw new CHttpException(404, 'Staff member not found.');
    //     }
    //     // print_r($categoryId);exit;
    //     // You may want to pass $categoryId, $serviceId, and $employee to the view
    //     $category = Category::model()->findByPk($categoryId);
    //     $service = ServiceType::model()->findByPk($serviceId);

    //     // Render the step4 view with the required data
    //     $this->render('step4', [
    //         'employee' => $employee,
    //         'category' => $category,
    //         'service' => $service,
    //         'staff_id' => $staff_id,
    //     ]);
    // }

    //     public function actionStep4()
    // {
    //     // Store staff ID in session if posted
    //     if (isset($_POST['staff_id'])) {
    //         Yii::app()->session['staff_id'] = $_POST['staff_id'];
    //     }

    //     // Fallback: Try to retrieve from session if not posted
    //     $staffId = isset($_POST['staff_id']) 
    //         ? (int)$_POST['staff_id'] 
    //         : (isset($_GET['staff']) 
    //             ? (int)$_GET['staff'] 
    //             : (Yii::app()->session['staff_id'] ?? null)
    //         );

    //     if (!$staffId) {
    //         throw new CHttpException(400, 'Staff member not specified.');
    //     }

    //     // Retrieve category and service if available
    //     $categoryId = $_POST['category_id'] ?? Yii::app()->session['category'] ?? null;
    //     $serviceId  = $_POST['service_id']  ?? Yii::app()->session['service']  ?? null;

    //     // Save to session for continuity
    //     if ($categoryId) Yii::app()->session['category'] = $categoryId;
    //     if ($serviceId)  Yii::app()->session['service']  = $serviceId;

    //     // Get employee record
    //     $employee = Employee::model()->find('user_id = :uid', [':uid' => $staffId]);

    //     if (!$employee) {
    //         throw new CHttpException(404, 'Staff not found.');
    //     }

    //     $slots = [];

    //     if (isset($_POST['date'])) {
    //         $selectedDate = $_POST['date']; // format: yyyy-mm-dd
    //         $dayOfWeek = strtolower(date('l', strtotime($selectedDate))); // e.g., 'thursday'

    //         // Check if employee is available on this day
    //         $availability = EmployeeAvailability::model()->findByAttributes([
    //             'employee_id' => $employee->id,
    //             'day' => $dayOfWeek,
    //             'enabled' => 1
    //         ]);

    //         if ($availability) {
    //             // Get all time slots for this availability
    //             $slots = EmployeeAvailabilitySlot::model()->findAllByAttributes([
    //                 'availability_id' => $availability->id
    //             ]);
    //         }

    //         // Save selected date to session
    //         Yii::app()->session['date'] = $selectedDate;
    //     }

    //     $this->render('step4', [
    //         'employee'   => $employee,
    //         'slots'      => $slots,
    //         'staffId'    => $staffId,
    //         'categoryId' => $categoryId,
    //         'serviceId'  => $serviceId,
    //     ]);
    // }


    //     public function actionStep5()
    // {
    //     // Store date and slot into session if posted
    //     if (isset($_POST['selected_date']) && isset($_POST['selected_slot'])) {
    //         Yii::app()->session['date'] = $_POST['selected_date'];
    //         Yii::app()->session['time'] = $_POST['selected_slot'];
    //     }

    //     // Get staff from POST and store it as well (if sent)
    //     if (isset($_POST['staff_id'])) {
    //         Yii::app()->session['staff'] = $_POST['staff_id'];
    //     }

    //     // Retrieve all required data from session
    //     $categoryId = Yii::app()->session['category'] ?? null;
    //     $serviceId  = Yii::app()->session['service'] ?? null;
    //     $staffId    = Yii::app()->session['staff'] ?? null;
    //     $date       = Yii::app()->session['date'] ?? null;
    //     $slot       = Yii::app()->session['time'] ?? null;

    //     // Validate all required fields
    //     if (!$categoryId || !$serviceId || !$staffId || !$date || !$slot) {
    //         throw new CHttpException(400, 'Missing booking details.');
    //     }

    //     // Load models
    //     $category = Category::model()->findByPk($categoryId);
    //     $service  = ServiceType::model()->findByPk($serviceId);
    //     $employee = Employee::model()->find('user_id = :uid', [':uid' => $staffId]);

    //     if (!$employee || !$category || !$service) {
    //         throw new CHttpException(404, 'Booking data not found.');
    //     }

    //     // Pass all data to the view
    //     $this->render('step5', [
    //         'category' => $category,
    //         'service'  => $service,
    //         'employee' => $employee,
    //         'date'     => $date,
    //         'slot'     => $slot,
    //     ]);
    // }



    // public function actionStep5()
    // {
    //     // $staffId = $_GET['staff'] ?? null;
    //     // $date = $_GET['date'] ?? null;
    //     // $slot = $_GET['slot'] ?? null;
    //     if (isset($_POST['selected_date']) && isset($_POST['selected_slot'])) {
    //         Yii::app()->session['date'] = $_POST['selected_date'];
    //         Yii::app()->session['time'] = $_POST['selected_slot'];
    //     }
    //     $staffId = $_POST['staff_id'] ?? null;
    //     $date = $_POST['selected_date'] ?? null;
    //     $slot = $_POST['selected_slot'] ?? null;

    //     if (!$staffId || !$date || !$slot) {
    //         throw new CHttpException(400, 'Missing booking details.');
    //     }

    //     $employee = Employee::model()->find('user_id = :uid', [':uid' => $staffId]);
    //     if (!$employee) {
    //         throw new CHttpException(404, 'Staff not found.');
    //     }

    //     // Here you'd also pull the selected category, service, and price if applicable
    //     // Probably from session or previous steps

    //     $this->render('step5', [
    //         'employee' => $employee,
    //         'date' => $date,
    //         'slot' => $slot,
    //         // 'category' => ..., 'service' => ..., etc.
    //     ]);
    // }



    // Find availability records related to this employee
    // $availabilities = EmployeeAvailability::model()->findAllByAttributes([
    //     'employee_id' => $employee->user_id
    // ]);

    // $availabilityIds = array_map(function ($a) {
    //     return $a->id;
    // }, $availabilities);

    // // Now fetch slots for those availability IDs
    // $slots = EmployeeAvailabilitySlot::model()->findAllByAttributes([
    //     'availability_id' => $availabilityIds
    // ]);


    // $availableSlots = [];
    // foreach ($slots as $slot) {
    //     // Example: split 09:00 to 13:00 into 30-minute slots
    //     $start = strtotime($slot->from_time);
    //     $end = strtotime($slot->to_time);
    //     while ($start + 1800 <= $end) {
    //         $next = $start + 1800; // 30 mins
    //         $availableSlots[] = date('g:i A', $start) . ' - ' . date('g:i A', $next);
    //         $start = $next + 600; // add 10 mins break
    //     }
    // }

    // $this->render('step4', [
    //     'staff' => $employee,
    //     'availableSlots' => $availableSlots,
    //     'staffId' => $userId,
    // ]);



    // Controller: AppointmentController.php (example)
    // Controller: AppointmentController.php







    //     public function actionStep4()
    // {
    //     if (!isset($_GET['staff'])) {
    //         throw new CHttpException(400, 'Staff member not specified.');
    //     }

    //     $userId = (int) $_GET['staff'];

    //     // Search employee by user_id instead of id
    //     $staff = Employee::model()->with('user')->findByAttributes(['user_id' => $userId]);

    //     if ($staff === null) {
    //         throw new CHttpException(404, 'Staff not found.');
    //     }

    //     // Dummy time slots for now
    //     $availableSlots = [
    //         '9:40 AM - 10:10 AM',
    //         '10:20 AM - 10:50 AM',
    //         '11:00 AM - 11:30 AM',
    //     ];

    //     $this->render('step4', [
    //         'staff' => $staff,
    //         'availableSlots' => $availableSlots,
    //          'staffId' => $userId,
    //     ]);
    // }

    // public function actiongetAvailabilitySlots()
    // {
    //     // Get input parameters
    //     $staffId = $_GET['staff_id'] ?? null;
    //     $date = $_GET['date'] ?? null;

    //     if (!$staffId || !$date) {
    //         http_response_code(400);
    //         echo json_encode(['error' => 'Missing staff_id or date']);
    //         exit;
    //     }

    //     // Load availability for staff on selected date's weekday
    //     $weekday = date('l', strtotime($date)); // e.g. Monday, Tuesday

    //     // Assume $this->AvailabilityModel fetches availability for staff and weekday
    //     $availability = $this->AvailabilityModel->getByStaffAndDay($staffId, $weekday);
    //     print_r($availability);
    //     exit;
    //     if (!$availability) {
    //         echo json_encode(['slots' => []]);
    //         exit;
    //     }

    //     $slots = [];
    //     foreach ($availability as $avail) {
    //         $start = new DateTime($avail['from_time']);
    //         $end = new DateTime($avail['to_time']);

    //         // Generate 30 min slots within this availability window
    //         while ($start < $end) {
    //             $slotEnd = clone $start;
    //             $slotEnd->modify('+30 minutes');
    //             if ($slotEnd > $end) break;

    //             $slots[] = $start->format('H:i') . ' - ' . $slotEnd->format('H:i');
    //             $start->modify('+40 minutes'); // 30 min slot + 10 min break
    //         }
    //     }

    //     echo json_encode(['slots' => $slots]);
    //     exit;
    // }




}
