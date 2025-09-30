<?php

/** @var string $template */
/** Params extracted in index.php via extract($params) */
?>
<!doctype html>
<html lang="<?= getCurrentLanguage() ?>">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?= t('site_name') ?></title>



	<?php if (file_exists(__DIR__ . '/../assets/images/favicon.png')): ?>
		<img src="assets/images/favicon.png" alt="SkyBook Logo" class="h-12 w-12 object-contain" />
	<?php else: ?>
		<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>✈️</text></svg>" />
	<?php endif; ?>

	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			darkMode: 'class',
			theme: {
				extend: {
					colors: {
						primary: '#6366f1',
						secondary: '#8b5cf6',
					}
				}
			}
		}
	</script>
	<!-- React Icons via Iconify -->
	<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
	<!-- React Hot Toast -->
	<script src="https://cdn.jsdelivr.net/npm/react@18.2.0/umd/react.production.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/react-dom@18.2.0/umd/react-dom.production.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/react-hot-toast@2.4.1/dist/index.umd.js"></script>
	<link rel="stylesheet" href="/styles.css" />
</head>

<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen transition-colors duration-300">
	<?php
	// Detect if we're on an admin page
	$currentRoute = $_GET['r'] ?? 'flights/search';
	$isAdminPage = strpos($currentRoute, 'admin') === 0;
	?>
	<header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-indigo-100 dark:border-gray-700 sticky top-0 z-50 shadow-sm transition-colors duration-300">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-16">
				<!-- Logo & Brand -->
				<a href="index.php?r=flights/search" class="flex items-center space-x-3 group">
					<?php if (file_exists(__DIR__ . '/../assets/images/logo.png')): ?>
						<img src="assets/images/logo.png" alt="SkyBook Logo" class="h-12 w-12 object-contain" />
					<?php else: ?>
						<div class="relative">
							<div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition"></div>
							<div class="relative bg-gradient-to-r from-indigo-600 to-purple-800 p-2.5 rounded-xl shadow-lg">
								<span class="iconify text-white text-xl" data-icon="mdi:airplane"></span>
							</div>
						</div>
					<?php endif; ?>
					<div class="flex flex-col">
						<span class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">SkyBook</span>
						<span class="text-xs text-gray-500 dark:text-gray-400 -mt-1">Book Your Journey</span>
					</div>
				</a>

				<!-- Right Side: Dark Mode + Menu Button -->
				<div class="flex items-center gap-2">
					<?php if (!$isAdminPage): ?>
						<!-- Language Switcher -->
						<div class="relative group">
							<button class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 transition flex items-center gap-1">
								<span class="text-2xl"><?= getAvailableLanguages()[getCurrentLanguage()]['flag'] ?></span>
							</button>
							<div class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-xl border-2 border-indigo-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
								<?php foreach (getAvailableLanguages() as $code => $lang): ?>
									<a href="index.php?r=language/set&lang=<?= $code ?>&redirect=<?= urlencode($currentRoute) ?>"
										class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-50 dark:hover:bg-gray-700 transition first:rounded-t-lg last:rounded-b-lg <?= getCurrentLanguage() === $code ? 'bg-indigo-50 dark:bg-gray-700' : '' ?>">
										<span class="text-xl dark:text-white text-gray-700"><?= $lang['flag'] ?></span>
										<span class="text-sm font-medium text-gray-700 dark:text-gray-200"><?= $lang['name'] ?></span>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<!-- Dark Mode Toggle -->
					<button id="theme-toggle" class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 transition">
						<span class="iconify text-xl dark:hidden" data-icon="mdi:weather-night"></span>
						<span class="iconify text-xl hidden dark:inline" data-icon="mdi:weather-sunny"></span>
					</button>

					<!-- Hamburger Menu Button (Hidden on Admin Pages) -->
					<?php if (!$isAdminPage): ?>
						<button id="sidebar-toggle" class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 transition">
							<span class="iconify text-2xl" data-icon="mdi:menu"></span>
						</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>

	<!-- Sidebar Drawer (Hidden on Admin Pages) -->
	<?php if (!$isAdminPage): ?>
		<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden transition-opacity duration-300"></div>
		<aside id="sidebar" class="fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-900 shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
			<div class="flex flex-col h-full">
				<!-- Sidebar Header -->
				<div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
					<div class="flex items-center space-x-3">
						<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
							<span class="iconify text-white text-xl" data-icon="mdi:airplane-takeoff"></span>
						</div>

						<span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"><?= t('site_name') ?></span>
					</div>
					<button id="sidebar-close" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
						<span class="iconify text-2xl" data-icon="mdi:close"></span>
					</button>
				</div>

				<!-- Sidebar Navigation -->
				<nav class="flex-1 overflow-y-auto p-4 space-y-2">
					<a href="index.php?r=flights/search" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">
						<span class="iconify text-xl" data-icon="mdi:home"></span>
						<span><?= t('home') ?></span>
					</a>

					<?php if (!empty($_SESSION['user_id'])): ?>
						<a href="index.php?r=user/tickets" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">
							<span class="iconify text-xl" data-icon="mdi:ticket"></span>
							<span><?= t('my_tickets') ?></span>
						</a>

						<?php
						try {
							$notifCount = 0;
							$pdoTmp = function_exists('db') ? db() : null;
							if ($pdoTmp) {
								if (class_exists('Notification')) {
									$notifCount = (new Notification($pdoTmp))->countUnread((int)$_SESSION['user_id']);
								} else {
									$stmtTmp = $pdoTmp->prepare('SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0');
									$stmtTmp->execute([(int)$_SESSION['user_id']]);
									$notifCount = (int)$stmtTmp->fetchColumn();
								}
							}
						} catch (Throwable $e) {
							$notifCount = 0;
						}
						?>

						<a href="index.php?r=user/notifications" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">
							<div class="flex items-center gap-3">
								<span class="iconify text-xl" data-icon="mdi:bell"></span>
								<span><?= t('notifications') ?></span>
							</div>
							<?php if ($notifCount > 0): ?>
								<span class="bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center animate-pulse"><?= (int)$notifCount ?></span>
							<?php endif; ?>
						</a>

						<a href="index.php?r=auth/profile" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">
							<span class="iconify text-xl" data-icon="mdi:account-circle"></span>
							<span><?= t('profile') ?></span>
						</a>

						<div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

						<a href="index.php?r=auth/logout" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition font-medium">
							<span class="iconify text-xl" data-icon="mdi:logout"></span>
							<span><?= t('logout') ?></span>
						</a>
					<?php else: ?>
						<a href="index.php?r=auth/login" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">
							<span class="iconify text-xl" data-icon="mdi:login"></span>
							<span><?= t('login') ?></span>
						</a>

						<a href="index.php?r=auth/register" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:shadow-lg transition font-medium">
							<span class="iconify text-xl" data-icon="mdi:account-plus"></span>
							<span><?= t('register') ?></span>
						</a>
					<?php endif; ?>
				</nav>

				<!-- Sidebar Footer -->
				<div class="p-4 border-t border-gray-200 dark:border-gray-700">
					<p class="text-xs text-gray-500 dark:text-gray-400 text-center">© <?= date('Y') ?> SkyBook</p>
				</div>
			</div>
		</aside>
	<?php endif; ?>

	<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		<?php if (!empty($_SESSION['flash'])): ?>
			<div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
				<div class="flex items-center">
					<i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
					<p class="text-green-800 font-medium"><?= htmlspecialchars((string)$_SESSION['flash']) ?></p>
				</div>
			</div>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<?php include $viewFile; ?>
	</main>
	<footer class="bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 border-t-2 border-indigo-100 dark:border-gray-800 mt-16 transition-colors duration-300">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
			<!-- Main Footer Content -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
				<!-- Brand Section -->
				<div class="md:col-span-2">
					<div class="flex items-center space-x-3 mb-4">
						<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-3 rounded-xl shadow-lg">
							<span class="iconify text-white text-2xl" data-icon="mdi:airplane-takeoff"></span>
						</div>
						<span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">SkyBook</span>
					</div>
					<p class="text-gray-600 dark:text-gray-400 mb-4 max-w-md">
						Your trusted partner for flight bookings. Experience seamless travel planning with competitive prices and excellent customer service.
					</p>
					<div class="flex gap-3">
						<a href="#" class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 hover:text-white dark:text-indigo-400 rounded-lg flex items-center justify-center transition">
							<span class="iconify" data-icon="mdi:facebook"></span>
						</a>
						<a href="#" class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 hover:text-white dark:text-indigo-400 rounded-lg flex items-center justify-center transition">
							<span class="iconify" data-icon="mdi:twitter"></span>
						</a>
						<a href="#" class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 hover:text-white dark:text-indigo-400 rounded-lg flex items-center justify-center transition">
							<span class="iconify" data-icon="mdi:instagram"></span>
						</a>
						<a href="#" class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 hover:text-white dark:text-indigo-400 rounded-lg flex items-center justify-center transition">
							<span class="iconify" data-icon="mdi:linkedin"></span>
						</a>
					</div>
				</div>

				<!-- Quick Links -->
				<div>
					<h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4"><?= t('quick_links') ?></h3>
					<ul class="space-y-2">
						<li><a href="index.php?r=flights/search" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center gap-2">
								<span class="iconify text-sm" data-icon="mdi:chevron-right"></span>
								<span><?= t('search_flights') ?></span>
							</a></li>
						<li><a href="index.php?r=user/tickets" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center gap-2">
								<span class="iconify text-sm" data-icon="mdi:chevron-right"></span>
								<span><?= t('my_tickets') ?></span>
							</a></li>
						<li><a href="index.php?r=auth/profile" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center gap-2">
								<span class="iconify text-sm" data-icon="mdi:chevron-right"></span>
								<span><?= t('my_profile') ?></span>
							</a></li>
					</ul>
				</div>

				<!-- Contact Info -->
				<div>
					<h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4"><?= t('contact_us') ?></h3>
					<ul class="space-y-3">
						<li class="flex items-start gap-2 text-gray-600 dark:text-gray-400">
							<span class="iconify text-indigo-600 dark:text-indigo-400 mt-1" data-icon="mdi:email"></span>
							<span>support@skybook.com</span>
						</li>
						<li class="flex items-start gap-2 text-gray-600 dark:text-gray-400">
							<span class="iconify text-indigo-600 dark:text-indigo-400 mt-1" data-icon="mdi:phone"></span>
							<span>+1 (555) 123-4567</span>
						</li>
						<li class="flex items-start gap-2 text-gray-600 dark:text-gray-400">
							<span class="iconify text-indigo-600 dark:text-indigo-400 mt-1" data-icon="mdi:map-marker"></span>
							<span>123 Sky Street, Cloud City</span>
						</li>
					</ul>
				</div>
			</div>

			<!-- Bottom Bar -->
			<div class="border-t border-gray-200 dark:border-gray-800 pt-6">
				<div class="flex flex-col md:flex-row justify-between items-center gap-4">
					<p class="text-gray-600 dark:text-gray-400 text-sm text-center md:text-left">
						&copy; <?= date('Y') ?> <?= t('site_name') ?>. <?= t('all_rights') ?>
					</p>
					<div class="flex items-center gap-2 text-sm">
						<span class="text-gray-500 dark:text-gray-500"><?= t('developed_with') ?></span>
						<span class="iconify text-red-500 animate-pulse" data-icon="mdi:heart"></span>
						<span class="text-gray-500 dark:text-gray-500"><?= t('by') ?></span>
						<span class="font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Joyy</span>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script>
		// Dark Mode Toggle
		(function() {
			const themeToggle = document.getElementById('theme-toggle');
			const html = document.documentElement;

			// Check for saved theme preference or default to light mode
			const currentTheme = localStorage.getItem('theme') || 'light';
			if (currentTheme === 'dark') {
				html.classList.add('dark');
			}

			if (themeToggle) {
				themeToggle.addEventListener('click', function() {
					html.classList.toggle('dark');
					const theme = html.classList.contains('dark') ? 'dark' : 'light';
					localStorage.setItem('theme', theme);
				});
			}
		})();

		// Sidebar Drawer Toggle
		(function() {
			const sidebarToggle = document.getElementById('sidebar-toggle');
			const sidebarClose = document.getElementById('sidebar-close');
			const sidebar = document.getElementById('sidebar');
			const overlay = document.getElementById('sidebar-overlay');

			function openSidebar() {
				sidebar.classList.remove('translate-x-full');
				overlay.classList.remove('hidden');
				document.body.style.overflow = 'hidden';
			}

			function closeSidebar() {
				sidebar.classList.add('translate-x-full');
				overlay.classList.add('hidden');
				document.body.style.overflow = '';
			}

			if (sidebarToggle) {
				sidebarToggle.addEventListener('click', openSidebar);
			}

			if (sidebarClose) {
				sidebarClose.addEventListener('click', closeSidebar);
			}

			if (overlay) {
				overlay.addEventListener('click', closeSidebar);
			}

			// Close sidebar when clicking a link
			const sidebarLinks = sidebar.querySelectorAll('a');
			sidebarLinks.forEach(link => {
				link.addEventListener('click', closeSidebar);
			});
		})();


		// Flash Message with Toast (if available)
		<?php if (!empty($_SESSION['flash'])): ?>
			if (typeof toast !== 'undefined') {
				toast.success('<?= addslashes(htmlspecialchars((string)$_SESSION['flash'])) ?>');
			}
		<?php endif; ?>
	</script>
</body>

</html>