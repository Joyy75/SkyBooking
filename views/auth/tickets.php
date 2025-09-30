<?php /** @var array $bookings */ ?>
<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-indigo-100 dark:border-gray-700">
    <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-8">
        <i class="fas fa-ticket-alt mr-2"></i><?= t('my_tickets') ?>
    </h2>
    <?php if (empty($bookings)): ?>
        <div class="text-center py-12">
            <i class="fas fa-ticket-alt text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">You have no bookings yet.</p>
            <a href="index.php?r=flights/search" class="inline-block mt-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                <i class="fas fa-search mr-2"></i><?= t('search_flights') ?>
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($bookings as $b): ?>
                <div class="bg-gradient-to-r from-white to-indigo-50/30 dark:from-gray-800 dark:to-indigo-900/20 rounded-xl shadow-lg hover:shadow-xl transition p-6 border border-indigo-100 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-1 rounded-full text-sm font-bold">
                                    <?= htmlspecialchars($b['flight_number']) ?>
                                </span>
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-chair mr-1"></i>Seat #<?= (int)$b['seat_number'] ?>
                                </span>
                                <?php if ((int)($b['confirmed'] ?? 0) === 1): ?>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Confirmed
                                    </span>
                                <?php else: ?>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center gap-4 text-lg">
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-gray-100"><?= htmlspecialchars($b['origin']) ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($b['departure_time']) ?></div>
                                </div>
                                <div class="flex-1 flex items-center">
                                    <div class="h-0.5 flex-1 bg-gradient-to-r from-indigo-300 to-purple-300"></div>
                                    <span class="iconify text-indigo-600 dark:text-indigo-400 mx-2 text-2xl" data-icon="mdi:airplane-takeoff"></span>
                                    <div class="h-0.5 flex-1 bg-gradient-to-r from-purple-300 to-pink-300"></div>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-gray-100"><?= htmlspecialchars($b['destination']) ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($b['arrival_time']) ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Booked on</div>
                            <div class="font-semibold text-gray-700 dark:text-gray-300"><?= htmlspecialchars($b['booked_at']) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
