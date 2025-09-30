<?php
declare(strict_types=1);

// Simple front controller and router

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/languages.php';

// Autoload models and controllers (very simple)
spl_autoload_register(function ($class) {
	$paths = [
		__DIR__ . '/models/' . $class . '.php',
		__DIR__ . '/controllers/' . $class . '.php',
	];
	foreach ($paths as $path) {
		if (file_exists($path)) {
			require_once $path;
			return;
		}
	}
});

// Configure session for persistence
if (session_status() === PHP_SESSION_NONE) {
	// Set session cookie to last 30 days
	ini_set('session.cookie_lifetime', '2592000');
	ini_set('session.gc_maxlifetime', '2592000');
	// Use cookies only (more reliable than URL params)
	ini_set('session.use_only_cookies', '1');
	// Strict session management
	ini_set('session.use_strict_mode', '1');
	session_start();
}

function view(string $template, array $params = []): void {
	extract($params, EXTR_SKIP);
	$viewFile = __DIR__ . '/views/' . $template . '.php';
	if (!file_exists($viewFile)) {
		http_response_code(404);
		echo 'View not found';
		return;
	}
	include __DIR__ . '/views/layout.php';
}

// Routes
$route = $_GET['r'] ?? 'flights/search';

try {
	$pdo = db();
	switch ($route) {
		case 'language/set': {
			$lang = $_GET['lang'] ?? 'en';
			setLanguage($lang);
			$redirect = $_GET['redirect'] ?? 'flights/search';
			header('Location: index.php?r=' . urlencode($redirect));
			exit;
		}
		case 'flights/search': {
			$controller = new FlightController($pdo);
			$controller->search();
			break;
		}
		case 'flights/list': {
			$controller = new FlightController($pdo);
			$controller->list();
			break;
		}
		case 'flights/details': {
			$controller = new FlightController($pdo);
			$controller->details();
			break;
		}
		case 'bookings/create': {
			$controller = new BookingController($pdo);
			$controller->create();
			break;
		}
		case 'bookings/store': {
			$controller = new BookingController($pdo);
			$controller->store();
			break;
		}
		case 'admin/login': {
			$controller = new AdminController($pdo);
			$controller->login();
			break;
		}
		case 'admin/auth': {
			$controller = new AdminController($pdo);
			$controller->authenticate();
			break;
		}
		case 'admin/logout': {
			$controller = new AdminController($pdo);
			$controller->logout();
			break;
		}
		case 'admin': {
			$controller = new AdminController($pdo);
			$controller->dashboard();
			break;
		}
		case 'admin/flights': {
			$controller = new AdminController($pdo);
			$controller->flightsIndex();
			break;
		}
		case 'admin/flights/new': {
			$controller = new AdminController($pdo);
			$controller->flightsNew();
			break;
		}
		case 'admin/flights/create': {
			$controller = new AdminController($pdo);
			$controller->flightsCreate();
			break;
		}
		case 'admin/flights/edit': {
			$controller = new AdminController($pdo);
			$controller->flightsEdit();
			break;
		}
		case 'admin/flights/update': {
			$controller = new AdminController($pdo);
			$controller->flightsUpdate();
			break;
		}
		case 'admin/flights/delete': {
			$controller = new AdminController($pdo);
			$controller->flightsDelete();
			break;
		}
		case 'admin/bookings': {
			$controller = new AdminController($pdo);
			$controller->bookingsIndex();
			break;
		}
		case 'admin/bookings/new': {
			$controller = new AdminController($pdo);
			$controller->bookingsNew();
			break;
		}
		case 'admin/bookings/create': {
			$controller = new AdminController($pdo);
			$controller->bookingsCreate();
			break;
		}
		case 'admin/bookings/edit': {
			$controller = new AdminController($pdo);
			$controller->bookingsEdit();
			break;
		}
		case 'admin/bookings/update': {
			$controller = new AdminController($pdo);
			$controller->bookingsUpdate();
			break;
		}
		case 'admin/bookings/delete': {
			$controller = new AdminController($pdo);
			$controller->bookingsDelete();
			break;
		}
		case 'admin/bookings/confirm': {
			$controller = new AdminController($pdo);
			$controller->bookingsConfirm();
			break;
		}
		case 'admin/users': {
			$controller = new AdminController($pdo);
			$controller->usersIndex();
			break;
		}
		case 'admin/users/delete': {
			$controller = new AdminController($pdo);
			$controller->usersDelete();
			break;
		}
		case 'auth/login': {
			$controller = new AuthController($pdo);
			$controller->login();
			break;
		}
		case 'auth/authenticate': {
			$controller = new AuthController($pdo);
			$controller->authenticate();
			break;
		}
		case 'auth/register': {
			$controller = new AuthController($pdo);
			$controller->register();
			break;
		}
		case 'auth/store': {
			$controller = new AuthController($pdo);
			$controller->store();
			break;
		}
		case 'auth/logout': {
			$controller = new AuthController($pdo);
			$controller->logout();
			break;
		}
		case 'auth/profile': {
			$controller = new AuthController($pdo);
			$controller->profile();
			break;
		}
		case 'auth/update': {
			$controller = new AuthController($pdo);
			$controller->update();
			break;
		}
		case 'user/tickets': {
			$controller = new AuthController($pdo);
			$controller->tickets();
			break;
		}
		case 'user/notifications': {
			$controller = new AuthController($pdo);
			$controller->notifications();
			break;
		}
		case 'user/notifications/mark-all': {
			$controller = new AuthController($pdo);
			$controller->notificationsMarkAll();
			break;
		}
		case 'api/notifications': {
			header('Content-Type: application/json');
			if (empty($_SESSION['user_id'])) {
				echo json_encode(['notifications' => []]);
				exit;
			}
			$notif = new Notification($pdo);
			$list = $notif->listForUser((int)$_SESSION['user_id']);
			echo json_encode(['notifications' => $list]);
			exit;
		}
		case 'api/notifications/mark-read': {
			header('Content-Type: application/json');
			if (empty($_SESSION['user_id'])) {
				echo json_encode(['success' => false]);
				exit;
			}
			$id = (int)($_GET['id'] ?? 0);
			$notif = new Notification($pdo);
			$notif->markRead($id, (int)$_SESSION['user_id']);
			echo json_encode(['success' => true]);
			exit;
		}
		default: {
			http_response_code(404);
			echo 'Route not found';
		}
	}
} catch (Throwable $e) {
	http_response_code(500);
	echo 'Application error: ' . htmlspecialchars($e->getMessage());
}


