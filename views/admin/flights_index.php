<?php /** @var array $flights */ ?>
<div class="space-y-6">
	<!-- Header -->
	<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-6 border border-indigo-100 dark:border-gray-700">
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-2">
					<span class="iconify" data-icon="mdi:airplane-takeoff"></span>
					<span>Manage Flights</span>
				</h2>
				<p class="text-gray-600 dark:text-gray-400 mt-1 text-sm md:text-base">Add, edit, or remove flights from the system</p>
			</div>
			<div class="flex flex-wrap gap-3">
				<a href="index.php?r=admin" class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<span class="iconify" data-icon="mdi:arrow-left"></span>
					<span>Dashboard</span>
				</a>
				<a href="index.php?r=admin/flights/new" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition">
					<span class="iconify" data-icon="mdi:plus"></span>
					<span>New Flight</span>
				</a>
			</div>
		</div>
	</div>

	<!-- Flights List -->
	<?php if (empty($flights)): ?>
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-12 text-center border border-indigo-100 dark:border-gray-700">
			<span class="iconify text-gray-300 dark:text-gray-600 text-6xl mb-4" data-icon="mdi:airplane-off"></span>
			<p class="text-gray-600 dark:text-gray-400 text-lg mb-4">No flights found.</p>
			<a href="index.php?r=admin/flights/new" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition">
				<span class="iconify" data-icon="mdi:plus"></span>
				<span>Add Your First Flight</span>
			</a>
		</div>
	<?php else: ?>
		<!-- Desktop Table View (hidden on mobile) -->
		<div class="hidden lg:block bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-indigo-100 dark:border-gray-700 overflow-hidden">
			<div class="overflow-x-auto">
				<table class="w-full">
					<thead class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30">
						<tr>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">#</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Flight</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Route</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Departs</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Arrives</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Price</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Seats</th>
							<th class="px-6 py-4 text-right text-sm font-bold text-gray-700 dark:text-gray-200">Actions</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					<?php foreach ($flights as $f): ?>
						<tr class="hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition">
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400"><?= (int)$f['id'] ?></td>
							<td class="px-6 py-4">
								<span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-bold">
									<?= htmlspecialchars($f['flight_number']) ?>
								</span>
							</td>
							<td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-medium">
								<?= htmlspecialchars($f['origin']) ?> <span class="iconify text-indigo-600 mx-1" data-icon="mdi:arrow-right"></span> <?= htmlspecialchars($f['destination']) ?>
							</td>
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400 text-sm"><?= htmlspecialchars($f['departure_time']) ?></td>
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400 text-sm"><?= htmlspecialchars($f['arrival_time']) ?></td>
							<td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-bold">$<?= number_format(((int)$f['price_cents']) / 100, 2) ?></td>
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400"><?= (int)$f['total_seats'] ?></td>
							<td class="px-6 py-4 text-right">
								<div class="flex justify-end gap-2">
									<a href="index.php?r=admin/flights/edit&id=<?= (int)$f['id'] ?>" class="inline-flex items-center gap-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/50 transition">
										<span class="iconify" data-icon="mdi:pencil"></span>
										<span>Edit</span>
									</a>
									<a href="index.php?r=admin/flights/delete&id=<?= (int)$f['id'] ?>" onclick="return confirm('Delete this flight?');" class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-200 dark:hover:bg-red-900/50 transition">
										<span class="iconify" data-icon="mdi:delete"></span>
										<span>Delete</span>
									</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Mobile Card View (shown on mobile) -->
		<div class="lg:hidden space-y-4">
			<?php foreach ($flights as $f): ?>
				<div class="bg-white dark:bg-gray-800 backdrop-blur-lg rounded-xl shadow-lg border-2 border-indigo-200 dark:border-gray-700 p-4">
					<div class="flex items-center justify-between mb-3">
						<span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-bold">
							<?= htmlspecialchars($f['flight_number']) ?>
						</span>
						<span class="text-xs text-gray-500 dark:text-gray-400">#<?= (int)$f['id'] ?></span>
					</div>
					
					<div class="space-y-2 mb-4">
						<div class="flex items-center gap-2">
							<span class="iconify text-blue-600 dark:text-blue-400" data-icon="mdi:airplane-takeoff"></span>
							<span class="text-sm font-medium text-gray-700 dark:text-gray-300"><?= htmlspecialchars($f['origin']) ?></span>
						</div>
						<div class="flex items-center gap-2">
							<span class="iconify text-purple-600 dark:text-purple-400" data-icon="mdi:airplane-landing"></span>
							<span class="text-sm font-medium text-gray-700 dark:text-gray-300"><?= htmlspecialchars($f['destination']) ?></span>
						</div>
						<div class="flex items-center gap-2">
							<span class="iconify text-orange-600 dark:text-orange-400" data-icon="mdi:clock-start"></span>
							<span class="text-xs text-gray-600 dark:text-gray-400"><?= htmlspecialchars($f['departure_time']) ?></span>
						</div>
						<div class="flex items-center gap-2">
							<span class="iconify text-pink-600 dark:text-pink-400" data-icon="mdi:clock-end"></span>
							<span class="text-xs text-gray-600 dark:text-gray-400"><?= htmlspecialchars($f['arrival_time']) ?></span>
						</div>
					</div>
					
					<div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
						<div>
							<div class="text-xs text-gray-500 dark:text-gray-400">Price</div>
							<div class="text-xl font-bold text-indigo-600 dark:text-indigo-400">$<?= number_format(((int)$f['price_cents']) / 100, 2) ?></div>
						</div>
						<div>
							<div class="text-xs text-gray-500 dark:text-gray-400">Seats</div>
							<div class="text-lg font-semibold text-gray-700 dark:text-gray-300"><?= (int)$f['total_seats'] ?></div>
						</div>
					</div>
					
					<div class="flex gap-2">
						<a href="index.php?r=admin/flights/edit&id=<?= (int)$f['id'] ?>" class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/50 transition">
							<span class="iconify" data-icon="mdi:pencil"></span>
							<span>Edit</span>
						</a>
						<a href="index.php?r=admin/flights/delete&id=<?= (int)$f['id'] ?>" onclick="return confirm('Delete this flight?');" class="flex-1 inline-flex items-center justify-center gap-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-200 dark:hover:bg-red-900/50 transition">
							<span class="iconify" data-icon="mdi:delete"></span>
							<span>Delete</span>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>



