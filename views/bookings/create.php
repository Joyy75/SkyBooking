<?php /** @var array $flight */ /** @var array $takenSeats */ ?>
<div class="max-w-5xl mx-auto space-y-6">
	<!-- Flight Info Header -->
	<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-6 shadow-2xl relative overflow-hidden">
		<div class="absolute inset-0 bg-black/10"></div>
		<div class="relative z-10">
			<div class="flex items-center justify-between mb-4">
				<div>
					<h2 class="text-3xl font-bold text-white mb-2">
						<i class="fas fa-plane-departure mr-2"></i>Book Flight <?= htmlspecialchars($flight['flight_number']) ?>
					</h2>
					<div class="flex items-center gap-4 text-white/90">
						<span class="text-lg font-semibold"><?= htmlspecialchars($flight['origin']) ?></span>
						<i class="fas fa-arrow-right"></i>
						<span class="text-lg font-semibold"><?= htmlspecialchars($flight['destination']) ?></span>
					</div>
				</div>
				<div class="text-right">
					<div class="text-white/80 text-sm">Price per seat</div>
					<div class="text-4xl font-bold text-white">$<?= number_format(((int)$flight['price_cents']) / 100, 2) ?></div>
				</div>
			</div>
			<div class="flex gap-6 text-white/90 text-sm">
				<span><i class="fas fa-calendar mr-2"></i>Departure: <?= htmlspecialchars($flight['departure_time']) ?></span>
				<span><i class="fas fa-clock mr-2"></i>Arrival: <?= htmlspecialchars($flight['arrival_time']) ?></span>
			</div>
		</div>
	</div>

	<!-- Booking Form with Seat Selection -->
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
		<!-- Seat Map -->
		<div class="lg:col-span-2 bg-white dark:bg-gray-800 backdrop-blur-lg rounded-2xl shadow-xl p-6 md:p-8 border-2 border-indigo-100 dark:border-gray-700">
			<h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
				<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:seat-passenger"></span>
				<span>Select Your Seat</span>
			</h3>
			<p class="text-gray-600 dark:text-gray-400 mb-6">Click on an available seat to select it</p>
			
			<!-- Airplane Layout -->
			<div class="bg-gradient-to-b from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-4 md:p-6 border-2 border-gray-300 dark:border-gray-600">
				<!-- Cockpit -->
				<div class="text-center mb-6">
					<div class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-full font-semibold">
						<i class="fas fa-plane text-xl"></i>
					</div>
				</div>

				<!-- Seats Grid -->
				<div class="grid grid-cols-6 gap-3 max-w-2xl mx-auto" id="seat-map">
					<?php
						$total = (int)$flight['total_seats'];
						$takenSet = array_fill_keys($takenSeats, true);
						for ($i = 1; $i <= $total; $i++):
							$isTaken = isset($takenSet[$i]);
							$seatClass = $isTaken ? 'seat-taken' : 'seat-available';
							// Add aisle space after column 3
							if ($i > 1 && ($i - 1) % 6 === 3): ?>
								<div class="col-span-6 h-4"></div>
							<?php endif; ?>
							<button type="button" 
								class="seat-btn <?= $seatClass ?> aspect-square rounded-lg font-bold text-sm transition-all duration-200 <?= $isTaken ? 'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'bg-white dark:bg-gray-700 border-2 border-indigo-300 dark:border-indigo-600 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white hover:scale-110 cursor-pointer' ?>"
								data-seat="<?= $i ?>"
								<?= $isTaken ? 'disabled' : '' ?>>
								<i class="fas fa-chair block mb-1"></i>
								<?= $i ?>
							</button>
					<?php endfor; ?>
				</div>

				<!-- Legend -->
				<div class="flex flex-wrap justify-center gap-4 md:gap-6 mt-8 text-sm">
					<div class="flex items-center gap-2">
						<div class="w-8 h-8 bg-white dark:bg-gray-700 border-2 border-indigo-300 dark:border-indigo-600 rounded-lg"></div>
						<span class="text-gray-700 dark:text-gray-300 font-medium">Available</span>
					</div>
					<div class="flex items-center gap-2">
						<div class="w-8 h-8 bg-indigo-600 rounded-lg"></div>
						<span class="text-gray-700 dark:text-gray-300 font-medium">Selected</span>
					</div>
					<div class="flex items-center gap-2">
						<div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
						<span class="text-gray-700 dark:text-gray-300 font-medium">Taken</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Booking Form -->
		<div class="bg-white dark:bg-gray-800 backdrop-blur-lg rounded-2xl shadow-xl p-6 border-2 border-indigo-100 dark:border-gray-700 h-fit">
			<h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
				<span class="iconify text-purple-600 dark:text-purple-400" data-icon="mdi:account"></span>
				<span><?= t('passenger_details') ?></span>
			</h3>
			<form method="post" action="index.php?r=bookings/store" id="booking-form">
				<input type="hidden" name="flight_id" value="<?= (int)$flight['id'] ?>" />
				<input type="hidden" name="seat_number" id="seat_number" value="" />
				
				<div class="space-y-4 mb-6">
					<div>
						<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
							<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:account"></span>
							<span><?= t('passenger_name') ?></span>
						</label>
						<input type="text" name="passenger_name" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="Full name" />
					</div>

					<div>
						<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
							<span class="iconify text-purple-600 dark:text-purple-400" data-icon="mdi:seat-passenger"></span>
							<span><?= t('selected_seat') ?></span>
						</label>
						<div id="selected-seat-display" class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 dark:text-gray-400 text-center">
							<?= t('no_seat_selected') ?>
						</div>
						<p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Click a seat on the map to select</p>
					</div>
				</div>

				<button type="submit" id="submit-btn" disabled class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed mb-3">
					<span class="iconify" data-icon="mdi:check-circle"></span>
					<span><?= t('confirm_booking') ?></span>
				</button>
				<a href="index.php?r=flights/details&id=<?= (int)$flight['id'] ?>" class="inline-flex items-center justify-center gap-2 w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<span class="iconify" data-icon="mdi:arrow-left"></span>
					<span><?= t('back_to_details') ?></span>
				</a>
			</form>
		</div>
	</div>
</div>

<script>
(function() {
	let selectedSeat = null;
	const seatInput = document.getElementById('seat_number');
	const seatDisplay = document.getElementById('selected-seat-display');
	const submitBtn = document.getElementById('submit-btn');
	const seatButtons = document.querySelectorAll('.seat-btn:not([disabled])');

	seatButtons.forEach(btn => {
		btn.addEventListener('click', function() {
			const seatNum = this.getAttribute('data-seat');
			
			// Deselect previous
			if (selectedSeat) {
				const prevBtn = document.querySelector(`.seat-btn[data-seat="${selectedSeat}"]`);
				if (prevBtn) {
					prevBtn.classList.remove('bg-indigo-600', 'text-white', 'scale-110', 'shadow-lg');
					prevBtn.classList.add('bg-white', 'border-2', 'border-indigo-300', 'text-indigo-700');
				}
			}

			// Select new
			selectedSeat = seatNum;
			this.classList.remove('bg-white', 'border-2', 'border-indigo-300', 'text-indigo-700');
			this.classList.add('bg-indigo-600', 'text-white', 'scale-110', 'shadow-lg');
			
			// Update form
			seatInput.value = seatNum;
			seatDisplay.textContent = `Seat #${seatNum}`;
			seatDisplay.classList.remove('text-gray-500');
			seatDisplay.classList.add('text-indigo-700', 'font-bold', 'bg-indigo-50');
			submitBtn.disabled = false;
		});
	});
})();
</script>



