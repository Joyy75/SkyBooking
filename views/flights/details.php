<?php /** @var array $flight */ /** @var array $seatStatuses */ ?>
<div class="max-w-5xl mx-auto space-y-6">
	<!-- Flight Header -->
	<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
		<div class="absolute inset-0 bg-black/10"></div>
		<div class="relative z-10">
			<h2 class="text-4xl font-bold text-white mb-4">
				<i class="fas fa-plane-departure mr-3"></i>Flight <?= htmlspecialchars($flight['flight_number']) ?>
			</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<div class="space-y-3 text-white/90">
					<div class="flex items-center gap-3">
						<i class="fas fa-route text-xl"></i>
						<span class="text-lg font-semibold"><?= htmlspecialchars($flight['origin']) ?> → <?= htmlspecialchars($flight['destination']) ?></span>
					</div>
					<div class="flex items-center gap-3">
						<i class="fas fa-calendar-alt"></i>
						<span>Departure: <?= htmlspecialchars($flight['departure_time']) ?></span>
					</div>
					<div class="flex items-center gap-3">
						<i class="fas fa-clock"></i>
						<span>Arrival: <?= htmlspecialchars($flight['arrival_time']) ?></span>
					</div>
				</div>
				<div class="text-right">
					<div class="text-white/80 text-sm mb-2">Price per seat</div>
					<div class="text-5xl font-bold text-white mb-3">$<?= number_format(((int)$flight['price_cents']) / 100, 2) ?></div>
					<div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
						<span class="text-white font-semibold">
							<i class="fas fa-chair mr-2"></i><?= (int)$flight['available_seats'] ?> / <?= (int)$flight['total_seats'] ?> seats available
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Action Buttons -->
	<div class="flex flex-col sm:flex-row gap-4">
		<?php if (!empty($_SESSION['user_id'])): ?>
			<a href="index.php?r=bookings/create&flight_id=<?= (int)$flight['id'] ?>" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition">
				<span class="iconify" data-icon="mdi:ticket"></span>
				<span><?= t('book_flight') ?></span>
			</a>
		<?php else: ?>
			<button onclick="alert('Please login or create an account to book flights.'); window.location.href='index.php?r=auth/login';" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition">
				<span class="iconify" data-icon="mdi:ticket"></span>
				<span><?= t('book_flight') ?></span>
			</button>
		<?php endif; ?>
		<a href="index.php?r=flights/search" class="inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-6 py-4 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition">
			<span class="iconify" data-icon="mdi:arrow-left"></span>
			<span><?= t('search_flights') ?></span>
		</a>
	</div>

	<!-- Seat Map -->
	<div class="bg-white dark:bg-gray-800 backdrop-blur-lg rounded-2xl shadow-xl p-6 md:p-8 border-2 border-indigo-100 dark:border-gray-700">
		<h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
			<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:seat-passenger"></span>
			<span><?= t('select_seat') ?></span>
		</h3>
		<p class="text-gray-600 dark:text-gray-400 mb-6">View current seat status for this flight</p>
		
		<!-- Airplane Layout -->
		<div class="bg-gradient-to-b from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-4 md:p-6 border-2 border-gray-300 dark:border-gray-600">
			<!-- Cockpit -->
			<div class="text-center mb-6">
				<div class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-full font-semibold">
					<i class="fas fa-plane text-xl"></i>
				</div>
			</div>

			<!-- Seats Grid -->
			<div class="grid grid-cols-6 gap-3 max-w-2xl mx-auto">
				<?php
					$total = (int)$flight['total_seats'];
					for ($i = 1; $i <= $total; $i++):
						$status = $seatStatuses[$i] ?? null;
						// Add aisle space
						if ($i > 1 && ($i - 1) % 6 === 3): ?>
							<div class="col-span-6 h-4"></div>
						<?php endif;
						
						$bgClass = 'bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/30 border-2 border-emerald-400 dark:border-emerald-500 text-emerald-700 dark:text-emerald-300';
						$icon = 'fa-chair';
						if ($status === 'pending') {
							$bgClass = 'bg-gradient-to-br from-amber-100 to-yellow-100 dark:from-amber-900/40 dark:to-yellow-900/40 border-2 border-amber-400 dark:border-amber-500 text-amber-700 dark:text-amber-300';
							$icon = 'fa-clock';
						} elseif ($status === 'confirmed') {
							$bgClass = 'bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900/40 dark:to-red-800/40 border-2 border-red-400 dark:border-red-600 text-red-700 dark:text-red-300';
							$icon = 'fa-times';
						}
				?>
					<div class="<?= $bgClass ?> aspect-square rounded-xl font-bold text-sm flex flex-col items-center justify-center hover:scale-105 transition shadow-md hover:shadow-xl">
						<i class="fas <?= $icon ?> text-lg mb-1"></i>
						<span class="text-xs font-bold"><?= $i ?></span>
					</div>
				<?php endfor; ?>
			</div>

			<!-- Legend -->
			<div class="flex flex-wrap justify-center gap-4 md:gap-6 mt-8 text-sm">
				<div class="flex items-center gap-2">
					<div class="w-10 h-10 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/30 border-2 border-emerald-400 dark:border-emerald-500 rounded-xl flex items-center justify-center shadow-md">
						<i class="fas fa-chair text-emerald-700 dark:text-emerald-300"></i>
					</div>
					<span class="text-gray-700 dark:text-gray-200 font-semibold">Available</span>
				</div>
				<div class="flex items-center gap-2">
					<div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-yellow-100 dark:from-amber-900/40 dark:to-yellow-900/40 border-2 border-amber-400 dark:border-amber-500 rounded-xl flex items-center justify-center shadow-md">
						<i class="fas fa-clock text-amber-700 dark:text-amber-300"></i>
					</div>
					<span class="text-gray-700 dark:text-gray-200 font-semibold">Pending</span>
				</div>
				<div class="flex items-center gap-2">
					<div class="w-10 h-10 bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900/40 dark:to-red-800/40 border-2 border-red-400 dark:border-red-600 rounded-xl flex items-center justify-center shadow-md">
						<i class="fas fa-times text-red-700 dark:text-red-300"></i>
					</div>
					<span class="text-gray-700 dark:text-gray-200 font-semibold">Booked</span>
				</div>
			</div>
		</div>
	</div>
</div>


