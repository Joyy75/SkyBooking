<?php /** @var array $bookings */ ?>
<div class="space-y-6">
	<!-- Header -->
	<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-6 border border-green-100 dark:border-gray-700">
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent flex items-center gap-2">
					<span class="iconify" data-icon="mdi:clipboard-list"></span>
					<span>Manage Bookings</span>
				</h2>
				<p class="text-gray-600 dark:text-gray-400 mt-1 text-sm md:text-base">View, confirm, and manage all bookings</p>
			</div>
			<div class="flex flex-wrap gap-3">
				<a href="index.php?r=admin" class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<span class="iconify" data-icon="mdi:arrow-left"></span>
					<span>Dashboard</span>
				</a>
				<a href="index.php?r=admin/bookings/new" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition">
					<span class="iconify" data-icon="mdi:plus"></span>
					<span>New Booking</span>
				</a>
			</div>
		</div>
	</div>

	<!-- Bookings List -->
	<?php if (empty($bookings)): ?>
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-12 text-center border border-green-100 dark:border-gray-700">
			<i class="fas fa-ticket-alt text-gray-300 text-6xl mb-4"></i>
			<p class="text-gray-600 text-lg mb-4">No bookings yet.</p>
			<a href="index.php?r=admin/bookings/new" class="inline-block bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition">
				<i class="fas fa-plus mr-2"></i>Add Your First Booking
			</a>
		</div>
	<?php else: ?>
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-green-100 dark:border-gray-700 overflow-hidden">
			<div class="overflow-x-auto">
				<table class="w-full">
					<thead class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30">
						<tr>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">#</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Flight</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Route</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Passenger</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Seat</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Booked At</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Status</th>
							<th class="px-6 py-4 text-right text-sm font-bold text-gray-700 dark:text-gray-200">Actions</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					<?php foreach ($bookings as $b): ?>
						<tr class="hover:bg-green-50/50 dark:hover:bg-green-900/20 transition">
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400"><?= (int)$b['id'] ?></td>
							<td class="px-6 py-4">
								<span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-bold">
									<?= htmlspecialchars($b['flight_number']) ?>
								</span>
							</td>
							<td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-medium">
								<?= htmlspecialchars($b['origin']) ?> <i class="fas fa-arrow-right text-green-600 mx-1"></i> <?= htmlspecialchars($b['destination']) ?>
							</td>
							<td class="px-6 py-4 text-gray-800 dark:text-gray-200">
								<i class="fas fa-user text-gray-400 mr-2"></i><?= htmlspecialchars($b['passenger_name']) ?>
							</td>
							<td class="px-6 py-4">
								<span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-lg text-sm font-semibold">
									<i class="fas fa-chair mr-1"></i>#<?= (int)$b['seat_number'] ?>
								</span>
							</td>
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400 text-sm"><?= htmlspecialchars($b['booked_at']) ?></td>
							<td class="px-6 py-4">
								<?php if ((int)($b['confirmed'] ?? 0) === 1): ?>
									<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
										<i class="fas fa-check-circle mr-1"></i>Confirmed
									</span>
								<?php else: ?>
									<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
										<i class="fas fa-clock mr-1"></i>Pending
									</span>
								<?php endif; ?>
							</td>
							<td class="px-6 py-4 text-right">
								<div class="flex justify-end gap-2">
									<?php if (((int)($b['confirmed'] ?? 0)) !== 1): ?>
										<a href="index.php?r=admin/bookings/confirm&id=<?= (int)$b['id'] ?>" onclick="return confirm('Confirm this booking?');" class="inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-green-200 dark:hover:bg-green-900/50 transition">
											<span class="iconify" data-icon="mdi:check-circle"></span>
											<span>Confirm</span>
										</a>
									<?php endif; ?>
									<a href="index.php?r=admin/bookings/edit&id=<?= (int)$b['id'] ?>" class="inline-flex items-center gap-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/50 transition">
										<span class="iconify" data-icon="mdi:pencil"></span>
										<span>Edit</span>
									</a>
									<a href="index.php?r=admin/bookings/delete&id=<?= (int)$b['id'] ?>" onclick="return confirm('Delete this booking?');" class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-200 dark:hover:bg-red-900/50 transition">
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
	<?php endif; ?>
</div>


