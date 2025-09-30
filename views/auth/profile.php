<?php /** @var array $user */ /** @var array $bookings */ ?>
<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-6 sm:p-8 border border-indigo-100 dark:border-gray-700">
	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
		<h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-2">
			<span class="iconify" data-icon="mdi:account-circle"></span>
			<span><?= t('my_profile') ?></span>
		</h2>
		<a href="index.php?r=flights/search" class="inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
			<span class="iconify" data-icon="mdi:arrow-left"></span>
			<span>Back</span>
		</a>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
		<div class="text-center md:text-left">
			<?php if (!empty($user['avatar_url'])): ?>
				<img src="<?= htmlspecialchars($user['avatar_url']) ?>" alt="Avatar" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-200 shadow-lg mx-auto md:mx-0 mb-4" />
			<?php else: ?>
				<div class="w-32 h-32 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg mx-auto md:mx-0 mb-4">
					<?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
				</div>
			<?php endif; ?>
			<h3 class="text-xl font-bold text-gray-800 dark:text-gray-100"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h3>
			<p class="text-gray-600 dark:text-gray-400 flex items-center justify-center md:justify-start gap-2 mt-2">
				<i class="fas fa-envelope text-indigo-600"></i><?= htmlspecialchars($user['email']) ?>
			</p>
			<?php if ($user['country']): ?>
				<p class="text-gray-600 dark:text-gray-400 flex items-center justify-center md:justify-start gap-2 mt-1">
					<i class="fas fa-map-marker-alt text-purple-600"></i><?= htmlspecialchars($user['country']) ?>
				</p>
			<?php endif; ?>
		</div>
		<div class="md:col-span-2">
			<form method="post" action="index.php?r=auth/update" enctype="multipart/form-data" id="profile-form" class="space-y-6">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
					<div>
						<label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
							<i class="fas fa-user text-indigo-600 mr-2"></i><?= t('first_name') ?>
						</label>
						<input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
					</div>
					<div>
						<label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
							<i class="fas fa-user text-purple-600 mr-2"></i><?= t('last_name') ?>
						</label>
						<input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" />
					</div>
					<div>
						<label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
							<i class="fas fa-globe text-pink-600 mr-2"></i><?= t('country') ?>
						</label>
						<input type="text" name="country" value="<?= htmlspecialchars($user['country'] ?? '') ?>" class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition" />
					</div>
					<div>
						<label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
							<i class="fas fa-image text-indigo-600 mr-2"></i><?= t('upload_photo') ?>
						</label>
						<input type="file" name="avatar" accept="image/*" class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
					</div>
				</div>
				<button type="submit" id="update-btn" disabled class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition disabled:opacity-50 disabled:cursor-not-allowed">
					<i class="fas fa-save mr-2"></i><?= t('update_profile') ?>
				</button>
			</form>
		</div>
	</div>

	<div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-4 border border-indigo-200 dark:border-indigo-800">
		<p class="text-gray-700 dark:text-gray-300">
			<i class="fas fa-ticket-alt text-indigo-600 mr-2"></i>
			See all your bookings in <a href="index.php?r=user/tickets" class="text-indigo-600 font-semibold hover:text-purple-600 transition">Your Tickets</a>.
		</p>
	</div>
</div>

<script>
(function(){
    const form = document.getElementById('profile-form');
    const btn = document.getElementById('update-btn');
    if (!form || !btn) return;
    const initial = new FormData(form);
    function markDirty(){
        const current = new FormData(form);
        let changed = false;
        for (const name of ['first_name','last_name','country']) {
            if ((initial.get(name) || '') !== (current.get(name) || '')) { changed = true; break; }
        }
        const fileInput = form.querySelector('input[name="avatar"]');
        if (!changed && fileInput && fileInput.files && fileInput.files.length > 0) changed = true;
        btn.disabled = !changed;
    }
    form.addEventListener('input', markDirty);
    form.addEventListener('change', markDirty);
})();
</script>
