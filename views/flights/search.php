<?php /** @var array $flights */ ?>
<section>
	<!-- Hero Section -->
	<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-6 md:p-8 mb-6 md:mb-8 shadow-2xl relative overflow-hidden mb-6 md:mb-8">
		<div class="absolute inset-0 bg-black/10"></div>
		<div class="relative z-10">
			<h1 class="text-2xl md:text-4xl font-bold text-white mb-4"><?= t('find_flight') ?></h1>
			<p class="text-indigo-100 text-sm md:text-lg flex items-center gap-2">
    <?= t('search_description') ?>
    <span class="iconify text-white" data-icon="mdi:world"></span>
</p>
		</div>

		<div class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white/10 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32"></div>
	</div>

	<!-- Search Form -->
	<form class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-4 md:p-8 mb-6 md:mb-8 border border-indigo-100 dark:border-gray-700" method="get" action="index.php">
		<input type="hidden" name="r" value="flights/search" />
		<div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6">
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:airplane-takeoff"></span>
					<span><?= t('from') ?></span>
				</label>
				<input type="text" name="origin" value="<?= htmlspecialchars((string)($origin ?? '')) ?>" placeholder="<?= t('origin_placeholder') ?>" class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
			</div>
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-purple-600 dark:text-purple-400" data-icon="mdi:airplane-landing"></span>
					<span><?= t('to') ?></span>
				</label>
				<input type="text" name="destination" value="<?= htmlspecialchars((string)($destination ?? '')) ?>" placeholder="<?= t('destination_placeholder') ?>" class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" />
			</div>
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-pink-600 dark:text-pink-400" data-icon="mdi:calendar"></span>
					<span><?= t('date') ?></span>
				</label>
				<input type="date" name="date" value="<?= htmlspecialchars((string)($date ?? '')) ?>" class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition" />
			</div>
			<div class="flex items-end">
				<button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition">
					<span class="iconify" data-icon="mdi:magnify"></span>
					<span><?= t('search_flights') ?></span>
				</button>
			</div>
		</div>
	</form>

	<?php if (!empty($flights)): ?>
		<div class="space-y-4">
			<h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6"><i class="fas fa-plane text-indigo-600 mr-2"></i><?= t('available_flights') ?></h2>
			<?php foreach ($flights as $f): ?>
				<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-lg hover:shadow-2xl transition p-6 border border-indigo-100 dark:border-gray-700">
					<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
						<div class="flex-1">
							<div class="flex items-center gap-3 mb-3">
								<span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-1 rounded-full text-sm font-bold"><?= htmlspecialchars($f['flight_number']) ?></span>
								<span class="text-gray-600 dark:text-gray-400 text-sm"><i class="fas fa-chair mr-1"></i><?= (int)$f['available_seats'] ?> / <?= (int)$f['total_seats'] ?> <?= t('seats_available') ?></span>
							</div>
							<div class="flex items-center gap-4 text-lg">
								<div class="text-center">
									<div class="font-bold text-gray-800 dark:text-gray-100"><?= htmlspecialchars($f['origin']) ?></div>
									<div class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($f['departure_time']) ?></div>
								</div>
								<div class="flex-1 flex items-center justify-center">
									<div class="h-0.5 flex-1 bg-gradient-to-r from-indigo-300 to-purple-300"></div>
									<span class="iconify text-indigo-600 dark:text-indigo-400 mx-2 text-2xl" data-icon="mdi:airplane-takeoff"></span>
									<div class="h-0.5 flex-1 bg-gradient-to-r from-purple-300 to-pink-300"></div>
								</div>
								<div class="text-center">
									<div class="font-bold text-gray-800 dark:text-gray-100"><?= htmlspecialchars($f['destination']) ?></div>
									<div class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($f['arrival_time']) ?></div>
								</div>
							</div>
						</div>
						<div class="flex flex-col items-end gap-3">
							<div class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">$<?= number_format(((int)$f['price_cents']) / 100, 2) ?></div>
							<a href="index.php?r=flights/details&id=<?= (int)$f['id'] ?>" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition inline-flex items-center gap-2">
								<span class="iconify" data-icon="mdi:information"></span>
								<span><?= t('view_details') ?></span>
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		<!-- Pagination -->
		<?php if (isset($totalPages) && $totalPages > 1): ?>
		<div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
			<div class="text-sm text-gray-600 dark:text-gray-400">
				Showing <span class="font-semibold text-indigo-600 dark:text-indigo-400"><?= count($flights) ?></span> of 
				<span class="font-semibold text-indigo-600 dark:text-indigo-400"><?= $totalFlights ?></span> flights
			</div>
			
			<div class="flex items-center gap-2">
				<!-- Previous Button -->
				<?php if ($page > 1): ?>
					<a href="?r=flights/search&origin=<?= urlencode($origin) ?>&destination=<?= urlencode($destination) ?>&date=<?= urlencode($date) ?>&page=<?= $page - 1 ?>" 
					   class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-2 border-indigo-200 dark:border-gray-700 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition font-medium">
						<span class="iconify" data-icon="mdi:chevron-left"></span>
						<span>Previous</span>
					</a>
				<?php else: ?>
					<span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-2 border-gray-200 dark:border-gray-800 rounded-lg cursor-not-allowed font-medium">
						<span class="iconify" data-icon="mdi:chevron-left"></span>
						<span>Previous</span>
					</span>
				<?php endif; ?>
				
				<!-- Page Numbers -->
				<div class="flex items-center gap-1">
					<?php 
					$startPage = max(1, $page - 2);
					$endPage = min($totalPages, $page + 2);
					
					if ($startPage > 1): ?>
						<a href="?r=flights/search&origin=<?= urlencode($origin) ?>&destination=<?= urlencode($destination) ?>&date=<?= urlencode($date) ?>&page=1" 
						   class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-2 border-indigo-200 dark:border-gray-700 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition font-medium">
							1
						</a>
						<?php if ($startPage > 2): ?>
							<span class="text-gray-400 px-2">...</span>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php for ($i = $startPage; $i <= $endPage; $i++): ?>
						<?php if ($i == $page): ?>
							<span class="w-10 h-10 flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-2 border-indigo-600 rounded-lg font-bold shadow-lg">
								<?= $i ?>
							</span>
						<?php else: ?>
							<a href="?r=flights/search&origin=<?= urlencode($origin) ?>&destination=<?= urlencode($destination) ?>&date=<?= urlencode($date) ?>&page=<?= $i ?>" 
							   class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-2 border-indigo-200 dark:border-gray-700 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition font-medium">
								<?= $i ?>
							</a>
						<?php endif; ?>
					<?php endfor; ?>
					
					<?php if ($endPage < $totalPages): ?>
						<?php if ($endPage < $totalPages - 1): ?>
							<span class="text-gray-400 px-2">...</span>
						<?php endif; ?>
						<a href="?r=flights/search&origin=<?= urlencode($origin) ?>&destination=<?= urlencode($destination) ?>&date=<?= urlencode($date) ?>&page=<?= $totalPages ?>" 
						   class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-2 border-indigo-200 dark:border-gray-700 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition font-medium">
							<?= $totalPages ?>
						</a>
					<?php endif; ?>
				</div>
				
				<!-- Next Button -->
				<?php if ($page < $totalPages): ?>
					<a href="?r=flights/search&origin=<?= urlencode($origin) ?>&destination=<?= urlencode($destination) ?>&date=<?= urlencode($date) ?>&page=<?= $page + 1 ?>" 
					   class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-2 border-indigo-200 dark:border-gray-700 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition font-medium">
						<span>Next</span>
						<span class="iconify" data-icon="mdi:chevron-right"></span>
					</a>
				<?php else: ?>
					<span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-2 border-gray-200 dark:border-gray-800 rounded-lg cursor-not-allowed font-medium">
						<span>Next</span>
						<span class="iconify" data-icon="mdi:chevron-right"></span>
					</span>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	<?php else: ?>
		<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-lg p-12 text-center border border-indigo-100 dark:border-gray-700">
			<i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
			<p class="text-gray-600 dark:text-gray-400 text-lg">No flights found. Try adjusting your search criteria.</p>
		</div>
	<?php endif; ?>
</section>



