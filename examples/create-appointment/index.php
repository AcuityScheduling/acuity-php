<?php

require_once(__DIR__.'/../../vendor/autoload.php');
require_once('../utils.php');

// Config:
$config = loadConfig();

// Instantiate API class:
$acuity = new AcuityScheduling(array(
	'userId' => $config['userId'],
	'apiKey' => $config['apiKey'],
	'base'   => $config['base'] // Optional
));

$engine = new \Handlebars\Handlebars(array(
	'loader' => new \Handlebars\Loader\FilesystemLoader(__DIR__, array( 'extension' => '.html' ))
));

$method = $_SERVER[REQUEST_METHOD];

if ($method === 'GET') {
	$start = true;
	$_SESSION['appointmentType'] = null;
	$_SESSION['date'] = null;
	$_SESSION['time'] = null;
}

if ($method === 'POST') {

	// Start of the flow:
	if (!$_POST) {

		// Fetch appointment types:
		$appointmentTypes = $acuity->request('/appointment-types');
		$_SESSION['appointmentTypes'] = $appointmentTypes;

	} elseif ($_POST['appointmentTypeID']) {

		// Appointment type selected:
		foreach ($_SESSION['appointmentTypes'] as $appointmentType) {
			if ($_POST['appointmentTypeID'] == $appointmentType['id']) {
				$_SESSION['appointmentType'] = $appointmentType;
				break;
			}
		}

		// Time to select a date:
		$month = strftime('%Y-%m');
		$dates = $acuity->request("/availability/dates?month=$month&appointmentTypeID={$_SESSION['appointmentType']['id']}");

	} elseif ($_POST['date']) {

		// Date selected.  Now select a time:
		$date = $_SESSION['date'] = $_POST['date'];
		$times = $acuity->request('/availability/times', array(
			'query' => array(
				'date' => $date,
				'appointmentTypeID' => $_SESSION['appointmentType']['id']
			)
		));

	} elseif ($_POST['time']) {

		// Time selected.  Now fill in appointmente details.
		$time = $_SESSION['time'] = $_POST['time'];

	} else {

		// Create the appointment:
		$appointment = $acuity->request('/appointments', array(
			'method' => 'POST',
			'data' => array(
				'appointmentTypeID' => $_SESSION['appointmentType']['id'],
				'datetime'          => $_SESSION['time'],
				'firstName'         => $_POST['firstName'],
				'lastName'          => $_POST['lastName'],
				'email'             => $_POST['email']
			)
		));
	}
}

$options = array(
	'start'            => $start,
	'appointmentTypes' => $appointmentTypes,
	'dates'            => $dates,
	'times'            => $times,
	'appointmentType'  => $_SESSION['appointmentType'],
	'date'             => $_SESSION['date'],
	'time'             => $_SESSION['time'],
	'appointment'      => $appointment ? json_encode($appointment, JSON_PRETTY_PRINT) : null
);

echo $engine->render('index', $options);
