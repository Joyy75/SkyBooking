<?php /** @var array $users */ ?>
<div class="space-y-6">
	<!-- Header -->
	<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-6 border border-purple-100 dark:border-gray-700">
		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center gap-2">
					<span class="iconify" data-icon="mdi:account-group"></span>
					<span>User Management</span>
				</h2>
				<p class="text-gray-600 dark:text-gray-400 mt-1 text-sm md:text-base">View and manage all registered users</p>
			</div>
			<a href="index.php?r=admin" class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
				<span class="iconify" data-icon="mdi:arrow-left"></span>
				<span>Dashboard</span>
			</a>
		</div>
	</div>

	<!-- Stats -->
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-lg p-6 border border-purple-100 dark:border-gray-700">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase mb-2">Total Users</p>
					<p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent"><?= count($users) ?></p>
				</div>
				<div class="bg-gradient-to-r from-purple-600 to-pink-600 p-3 rounded-xl">
					<span class="iconify text-white text-3xl" data-icon="mdi:account-multiple"></span>
				</div>
			</div>
		</div>

		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-lg p-6 border border-blue-100 dark:border-gray-700">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase mb-2">With Avatar</p>
					<p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent"><?= count(array_filter($users, fn($u) => !empty($u['avatar_url']))) ?></p>
				</div>
				<div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-3 rounded-xl">
					<span class="iconify text-white text-3xl" data-icon="mdi:account-circle"></span>
				</div>
			</div>
		</div>

		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-lg p-6 border border-green-100 dark:border-gray-700">
			<div class="flex items-center justify-between">
				<div>
					<p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase mb-2">Countries</p>
					<p class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"><?= count(array_unique(array_filter(array_column($users, 'country')))) ?></p>
				</div>
				<div class="bg-gradient-to-r from-green-600 to-emerald-600 p-3 rounded-xl">
					<span class="iconify text-white text-3xl" data-icon="mdi:earth"></span>
				</div>
			</div>
		</div>
	</div>

	<!-- Users List -->
	<?php if (empty($users)): ?>
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-12 text-center border border-purple-100 dark:border-gray-700">
			<span class="iconify text-gray-300 text-6xl mb-4" data-icon="mdi:account-off"></span>
			<p class="text-gray-600 text-lg">No users registered yet.</p>
		</div>
	<?php else: ?>
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-purple-100 dark:border-gray-700 overflow-hidden">
			<div class="overflow-x-auto">
				<table class="w-full">
					<thead class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30">
						<tr>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">#</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">User</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Email</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Name</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Country</th>
							<th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Registered</th>
							<th class="px-6 py-4 text-right text-sm font-bold text-gray-700 dark:text-gray-200">Actions</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					<?php foreach ($users as $u): ?>
						<tr class="hover:bg-purple-50/50 dark:hover:bg-purple-900/20 transition">
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400"><?= (int)$u['id'] ?></td>
							<td class="px-6 py-4">
								<div class="flex items-center gap-3">
									<?php if (!empty($u['avatar_url'])): ?>
										<img src="<?= htmlspecialchars($u['avatar_url']) ?>" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-purple-200 dark:border-purple-700" />
									<?php else: ?>
										<div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 flex items-center justify-center text-white font-bold">
											<?= strtoupper(substr($u['first_name'] ?? 'U', 0, 1) . substr($u['last_name'] ?? 'N', 0, 1)) ?>
										</div>
									<?php endif; ?>
								</div>
							</td>
							<td class="px-6 py-4">
								<div class="flex items-center gap-2 text-gray-800 dark:text-gray-200">
									<span class="iconify text-purple-600" data-icon="mdi:email"></span>
									<?= htmlspecialchars($u['email']) ?>
								</div>
							</td>
							<td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-medium">
								<?= htmlspecialchars(($u['first_name'] ?? '') . ' ' . ($u['last_name'] ?? '')) ?>
							</td>
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400">
								<?php if (!empty($u['country'])): ?>
									<div class="flex items-center gap-2">
										<span class="iconify text-green-600" data-icon="mdi:map-marker"></span>
										<?= htmlspecialchars($u['country']) ?>
									</div>
								<?php else: ?>
									<span class="text-gray-400">-</span>
								<?php endif; ?>
							</td>
							<td class="px-6 py-4 text-gray-600 dark:text-gray-400 text-sm"><?= htmlspecialchars($u['created_at']) ?></td>
							<td class="px-6 py-4 text-right">
								<a href="index.php?r=admin/users/delete&id=<?= (int)$u['id'] ?>" onclick="return confirm('Delete this user? This will also delete all their bookings and notifications.');" class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-200 dark:hover:bg-red-900/50 hover:shadow-md transition">
									<span class="iconify text-lg" data-icon="mdi:delete"></span>
									<span>Delete</span>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>
</div>
