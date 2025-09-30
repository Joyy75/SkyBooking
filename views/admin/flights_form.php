<?php /** @var array|null $flight */ ?>
<div class="max-w-4xl mx-auto">
	<div class="bg-white dark:bg-gray-800 backdrop-blur-lg rounded-2xl shadow-xl p-8 border-2 border-indigo-200 dark:border-gray-700">
		<!-- Header -->
		<div class="mb-8">
			<h2 class="text-3xl font-bold text-indigo-900 dark:text-white mb-4 flex items-center gap-2">
				<span class="iconify" data-icon="mdi:airplane-plus"></span>
				<span><?= $flight ? 'Edit Flight' : 'New Flight' ?></span>
			</h2>
			<a href="index.php?r=admin/flights" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition font-medium">
				<span class="iconify" data-icon="mdi:arrow-left"></span>
				<span>Back to flights</span>
			</a>
		</div>

		<form method="post" action="index.php?r=admin/flights/<?= $flight ? 'update' : 'create' ?>" class="space-y-6">
			<?php if ($flight): ?><input type="hidden" name="id" value="<?= (int)$flight['id'] ?>" /><?php endif; ?>
			
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<!-- Flight Number -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:airplane"></span>
						<span>Flight Number</span>
					</label>
					<input type="text" name="flight_number" value="<?= htmlspecialchars((string)($flight['flight_number'] ?? '')) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" 
						   placeholder="e.g., AA101" />
				</div>

				<!-- Price -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-green-600 dark:text-green-400" data-icon="mdi:currency-usd"></span>
						<span>Price (cents)</span>
					</label>
					<input type="number" name="price_cents" value="<?= htmlspecialchars((string)($flight['price_cents'] ?? '')) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition" 
						   placeholder="e.g., 35000 ($350.00)" />
				</div>

				<!-- Origin -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-blue-600 dark:text-blue-400" data-icon="mdi:airplane-takeoff"></span>
						<span>Origin</span>
					</label>
					<input type="text" name="origin" value="<?= htmlspecialchars((string)($flight['origin'] ?? '')) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
						   placeholder="e.g., New York (JFK)" />
				</div>

				<!-- Destination -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-purple-600 dark:text-purple-400" data-icon="mdi:airplane-landing"></span>
						<span>Destination</span>
					</label>
					<input type="text" name="destination" value="<?= htmlspecialchars((string)($flight['destination'] ?? '')) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
						   placeholder="e.g., Los Angeles (LAX)" />
				</div>

				<!-- Departure Time -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-orange-600 dark:text-orange-400" data-icon="mdi:clock-start"></span>
						<span>Departure Time</span>
					</label>
					<input type="datetime-local" name="departure_time" value="<?= htmlspecialchars(str_replace(' ', 'T', (string)($flight['departure_time'] ?? ''))) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" />
				</div>

				<!-- Arrival Time -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-pink-600 dark:text-pink-400" data-icon="mdi:clock-end"></span>
						<span>Arrival Time</span>
					</label>
					<input type="datetime-local" name="arrival_time" value="<?= htmlspecialchars(str_replace(' ', 'T', (string)($flight['arrival_time'] ?? ''))) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition" />
				</div>

				<!-- Total Seats -->
				<div>
					<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
						<span class="iconify text-teal-600 dark:text-teal-400" data-icon="mdi:seat-passenger"></span>
						<span>Total Seats</span>
					</label>
					<input type="number" name="total_seats" value="<?= htmlspecialchars((string)($flight['total_seats'] ?? '')) ?>" required 
						   class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition" 
						   placeholder="e.g., 180" />
				</div>
			</div>

			<!-- Action Buttons -->
			<div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
				<button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition">
					<span class="iconify" data-icon="mdi:content-save"></span>
					<span>Save Flight</span>
				</button>
				<a href="index.php?r=admin/flights" class="flex-1 inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<span class="iconify" data-icon="mdi:close"></span>
					<span>Cancel</span>
				</a>
			</div>
		</form>
	</div>
</div>



