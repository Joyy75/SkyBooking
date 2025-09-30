<?php /** @var array $stats */ ?>
<div class="space-y-6">
	<!-- Header -->
	<div class="bg-gradient-to-r from-indigo-100 via-purple-100 to-pink-100 dark:from-slate-700 dark:via-slate-800 dark:to-slate-900 rounded-2xl p-6 md:p-8 shadow-2xl relative overflow-hidden border-2 border-indigo-200 dark:border-transparent">
		<div class="absolute inset-0 bg-gradient-to-br from-white/40 to-transparent dark:bg-black/30"></div>
		<div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			<div>
				<h1 class="text-2xl md:text-4xl font-bold text-indigo-900 dark:text-white mb-2 flex items-center gap-2">
					<span class="iconify" data-icon="mdi:view-dashboard"></span>
					<span>Admin Dashboard</span>
				</h1>
				<p class="text-indigo-700 dark:text-white/90 text-sm md:text-lg">Manage your flight booking system</p>
			</div>
			<a href="index.php?r=admin/logout" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-white/20 dark:hover:bg-white/30 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg whitespace-nowrap">
				<span class="iconify" data-icon="mdi:logout"></span>
				<span>Logout</span>
			</a>
		</div>
	</div>

	<!-- Stats Cards -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
		<div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-700 backdrop-blur-lg rounded-2xl shadow-xl p-8 border-2 border-indigo-200 dark:border-gray-700 hover:shadow-2xl hover:border-indigo-300 dark:hover:border-gray-600 transition">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-indigo-700 dark:text-indigo-300 text-sm font-bold uppercase mb-2 tracking-wide">Total Flights</p>
					<p class="text-5xl font-bold text-indigo-600 dark:text-indigo-400"><?= (int)$stats['flights'] ?></p>
				</div>
				<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-xl shadow-lg">
					<span class="iconify text-white text-4xl" data-icon="mdi:airplane-takeoff"></span>
				</div>
			</div>
		</div>

		<div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-700 backdrop-blur-lg rounded-2xl shadow-xl p-8 border-2 border-green-200 dark:border-gray-700 hover:shadow-2xl hover:border-green-300 dark:hover:border-gray-600 transition">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-green-700 dark:text-green-300 text-sm font-bold uppercase mb-2 tracking-wide">Total Bookings</p>
					<p class="text-5xl font-bold text-green-600 dark:text-green-400"><?= (int)$stats['bookings'] ?></p>
				</div>
				<div class="bg-gradient-to-r from-green-600 to-emerald-600 p-4 rounded-xl shadow-lg">
					<span class="iconify text-white text-4xl" data-icon="mdi:ticket"></span>
				</div>
			</div>
		</div>
	</div>

	<!-- Quick Actions -->
	<div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-700 backdrop-blur-lg rounded-2xl shadow-xl p-8 border-2 border-blue-200 dark:border-gray-700">
		<h2 class="text-2xl font-bold text-blue-800 dark:text-gray-100 mb-6 flex items-center gap-2">
			<span class="iconify text-blue-600 dark:text-indigo-400 text-3xl" data-icon="mdi:lightning-bolt"></span>
			<span>Quick Actions</span>
		</h2>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<a href="index.php?r=admin/flights" class="group bg-gradient-to-br from-indigo-50 to-purple-50 dark:bg-gradient-to-br dark:from-indigo-900/20 dark:to-purple-900/20 hover:from-indigo-100 hover:to-purple-100 dark:hover:from-indigo-900/30 dark:hover:to-purple-900/30 p-6 rounded-xl border-2 border-indigo-200 dark:border-indigo-800 transition hover:shadow-lg">
				<div class="flex items-center gap-4">
					<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-xl group-hover:scale-110 transition shadow-lg">
						<span class="iconify text-white text-3xl" data-icon="mdi:airplane"></span>
					</div>
					<div class="flex-1">
						<h3 class="font-bold text-indigo-800 dark:text-gray-100 text-lg mb-1">Manage Flights</h3>
						<p class="text-indigo-600 dark:text-gray-400 text-sm">Add, edit, or delete flights</p>
					</div>
				</div>
			</a>

			<a href="index.php?r=admin/bookings" class="group bg-gradient-to-br from-green-50 to-emerald-50 dark:bg-gradient-to-br dark:from-green-900/20 dark:to-emerald-900/20 hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 p-6 rounded-xl border-2 border-green-200 dark:border-green-800 transition hover:shadow-lg">
				<div class="flex items-center gap-4">
					<div class="bg-gradient-to-r from-green-600 to-emerald-600 p-4 rounded-xl group-hover:scale-110 transition shadow-lg">
						<span class="iconify text-white text-3xl" data-icon="mdi:clipboard-text"></span>
					</div>
					<div class="flex-1">
						<h3 class="font-bold text-green-800 dark:text-gray-100 text-lg mb-1">View Bookings</h3>
						<p class="text-green-600 dark:text-gray-400 text-sm">Manage and confirm bookings</p>
					</div>
				</div>
			</a>

			<a href="index.php?r=admin/users" class="group bg-gradient-to-br from-purple-50 to-pink-50 dark:bg-gradient-to-br dark:from-purple-900/20 dark:to-pink-900/20 hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-900/30 dark:hover:to-pink-900/30 p-6 rounded-xl border-2 border-purple-200 dark:border-purple-800 transition hover:shadow-lg">
				<div class="flex items-center gap-4">
					<div class="bg-gradient-to-r from-purple-600 to-pink-600 p-4 rounded-xl group-hover:scale-110 transition shadow-lg">
						<span class="iconify text-white text-3xl" data-icon="mdi:account-group"></span>
					</div>
					<div class="flex-1">
						<h3 class="font-bold text-purple-800 dark:text-gray-100 text-lg mb-1">Manage Users</h3>
						<p class="text-purple-600 dark:text-gray-400 text-sm">View all registered users</p>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>



