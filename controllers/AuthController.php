<?php
declare(strict_types=1);

final class AuthController {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function login(): void {
		view('auth/login');
	}

	public function authenticate(): void {
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
			header('Location: index.php?r=auth/login');
			return;
		}
		$email = trim((string)($_POST['email'] ?? ''));
		$password = (string)($_POST['password'] ?? '');
		$userModel = new User($this->pdo);
		$user = $userModel->verifyPassword($email, $password);
		if ($user) {
			$_SESSION['user_id'] = (int)$user['id'];
			$_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
			$_SESSION['user_email'] = $user['email'];
			header('Location: index.php?r=flights/search');
			return;
		}
		$_SESSION['flash'] = 'Invalid email or password';
		header('Location: index.php?r=auth/login');
	}

	public function register(): void {
		view('auth/register');
	}

	public function store(): void {
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
			header('Location: index.php?r=auth/register');
			return;
		}
		$email = trim((string)($_POST['email'] ?? ''));
		$password = (string)($_POST['password'] ?? '');
		$firstName = trim((string)($_POST['first_name'] ?? ''));
		$lastName = trim((string)($_POST['last_name'] ?? ''));
		$country = trim((string)($_POST['country'] ?? ''));
		if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
			$_SESSION['flash'] = 'All fields are required';
			header('Location: index.php?r=auth/register');
			return;
		}
		$userModel = new User($this->pdo);
		if ($userModel->findByEmail($email)) {
			$_SESSION['flash'] = 'Email already exists';
			header('Location: index.php?r=auth/register');
			return;
		}
		try {
			$userId = $userModel->create($email, $password, $firstName, $lastName, $country ?: null);
			$_SESSION['user_id'] = $userId;
			$_SESSION['user_name'] = $firstName . ' ' . $lastName;
			$_SESSION['user_email'] = $email;
			$_SESSION['flash'] = 'Account created successfully';
			header('Location: index.php?r=flights/search');
		} catch (Throwable $e) {
			$_SESSION['flash'] = 'Error creating account: ' . $e->getMessage();
			header('Location: index.php?r=auth/register');
		}
	}

	public function logout(): void {
		unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
		header('Location: index.php?r=flights/search');
	}

	public function profile(): void {
		if (empty($_SESSION['user_id'])) {
			header('Location: index.php?r=auth/login');
			return;
		}
		$userModel = new User($this->pdo);
		$user = $userModel->find((int)$_SESSION['user_id']);
		$bookings = $userModel->getBookings((int)$_SESSION['user_id']);
		view('auth/profile', compact('user', 'bookings'));
	}

	public function update(): void {
		if (empty($_SESSION['user_id'])) {
			header('Location: index.php?r=auth/login');
			return;
		}
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
			header('Location: index.php?r=auth/profile');
			return;
		}
		$data = [
			'first_name' => trim((string)($_POST['first_name'] ?? '')),
			'last_name' => trim((string)($_POST['last_name'] ?? '')),
			'country' => trim((string)($_POST['country'] ?? '')),
		];

		// Handle avatar upload if present
		if (!empty($_FILES['avatar']['name'] ?? '')) {
			$err = $_FILES['avatar']['error'] ?? UPLOAD_ERR_NO_FILE;
			if ($err === UPLOAD_ERR_OK) {
				$tmp = (string)($_FILES['avatar']['tmp_name'] ?? '');
				$name = (string)($_FILES['avatar']['name'] ?? '');
				$size = (int)($_FILES['avatar']['size'] ?? 0);
				if ($size > 0 && $size <= 5 * 1024 * 1024) { // <=5MB
					$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
					$allowed = ['jpg','jpeg','png','gif','webp'];
					if (in_array($ext, $allowed, true)) {
						$destDir = __DIR__ . '/../storage/avatars';
						if (!is_dir($destDir)) {
							@mkdir($destDir, 0777, true);
						}
						$filename = 'u' . (int)$_SESSION['user_id'] . '_' . time() . '.' . $ext;
						$destPath = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $filename;
						if (move_uploaded_file($tmp, $destPath)) {
							$data['avatar_url'] = 'storage/avatars/' . $filename;
						}
					}
				}
			}
		}
		$userModel = new User($this->pdo);
		$userModel->update((int)$_SESSION['user_id'], $data);
		$_SESSION['user_name'] = $data['first_name'] . ' ' . $data['last_name'];
		$_SESSION['flash'] = 'Profile updated';
		header('Location: index.php?r=auth/profile');
	}

	public function tickets(): void {
		if (empty($_SESSION['user_id'])) { header('Location: index.php?r=auth/login'); return; }
		$userModel = new User($this->pdo);
		$bookings = $userModel->getBookings((int)$_SESSION['user_id']);
		view('auth/tickets', compact('bookings'));
	}

	public function notifications(): void {
		if (empty($_SESSION['user_id'])) { header('Location: index.php?r=auth/login'); return; }
		$notif = new Notification($this->pdo);
		$list = $notif->listForUser((int)$_SESSION['user_id']);
		view('auth/notifications', ['notifications' => $list]);
	}

	public function notificationsMarkAll(): void {
		if (empty($_SESSION['user_id'])) { header('Location: index.php?r=auth/login'); return; }
		$notif = new Notification($this->pdo);
		$notif->markAllRead((int)$_SESSION['user_id']);
		$_SESSION['flash'] = 'All notifications marked as read';
		header('Location: index.php?r=user/notifications');
	}
}
