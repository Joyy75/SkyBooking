<?php /** @var array $notifications */ ?>
<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-indigo-100 dark:border-gray-700">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-2">
            <span class="iconify" data-icon="mdi:bell"></span>
            <span><?= t('notifications') ?></span>
        </h2>
        <?php if (!empty($notifications)): ?>
            <a href="index.php?r=user/notifications/mark-all" class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                <span class="iconify" data-icon="mdi:check-all"></span>
                <span>Mark all as read</span>
            </a>
        <?php endif; ?>
    </div>
    <?php if (empty($notifications)): ?>
        <div class="text-center py-12">
            <div class="flex justify-center mb-4">
                <span class="iconify text-gray-300 dark:text-gray-600 text-6xl" data-icon="mdi:bell-off"></span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-lg font-semibold">No notifications yet.</p>
            <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">You'll be notified when your bookings are confirmed.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($notifications as $n): ?>
                <div class="notif-item cursor-pointer <?= ((int)$n['is_read'] === 1) ? 'bg-gray-50 dark:bg-gray-700/50' : 'bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20' ?> rounded-xl p-4 border <?= ((int)$n['is_read'] === 1) ? 'border-gray-200 dark:border-gray-600' : 'border-indigo-200 dark:border-indigo-800' ?> transition hover:shadow-md" 
                     data-id="<?= (int)$n['id'] ?>" 
                     data-message="<?= htmlspecialchars($n['message']) ?>" 
                     data-date="<?= htmlspecialchars($n['created_at']) ?>"
                     data-read="<?= (int)$n['is_read'] ?>">
                    <div class="flex items-start gap-4">
                        <div class="<?= ((int)$n['is_read'] === 1) ? 'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300' : 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white' ?> p-3 rounded-lg">
                            <span class="iconify text-lg" data-icon="<?= ((int)$n['is_read'] === 1) ? 'mdi:email-open' : 'mdi:email' ?>"></span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <?php if ((int)$n['is_read'] === 0): ?>
                                    <span class="new-badge bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-bold">NEW</span>
                                <?php endif; ?>
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($n['created_at']) ?></span>
                            </div>
                            <p class="text-gray-800 dark:text-gray-200 font-medium"><?= htmlspecialchars($n['message']) ?></p>
                        </div>
                        <span class="iconify text-gray-400 text-xl" data-icon="mdi:chevron-right"></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Notification Modal -->
<div id="notif-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full border border-gray-200 dark:border-gray-700 transform transition-all">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="iconify text-indigo-600" data-icon="mdi:email-open"></span>
                <span>Notification</span>
            </h3>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <span class="iconify text-2xl" data-icon="mdi:close"></span>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <span id="modal-date" class="text-sm text-gray-500 dark:text-gray-400"></span>
            </div>
            <p id="modal-message" class="text-gray-800 dark:text-gray-200 text-lg leading-relaxed"></p>
        </div>
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button id="modal-close-btn" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                <span class="iconify" data-icon="mdi:check"></span>
                <span>Close</span>
            </button>
        </div>
    </div>
</div>

<script>
// Notification tap-to-read functionality
(function() {
    const notifItems = document.querySelectorAll('.notif-item');
    const modal = document.getElementById('notif-modal');
    const closeModal = document.getElementById('close-modal');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const modalMessage = document.getElementById('modal-message');
    const modalDate = document.getElementById('modal-date');
    
    notifItems.forEach(item => {
        item.addEventListener('click', async function() {
            const notifId = this.getAttribute('data-id');
            const message = this.getAttribute('data-message');
            const date = this.getAttribute('data-date');
            const isRead = this.getAttribute('data-read');
            
            // Show modal
            modalMessage.textContent = message;
            modalDate.textContent = date;
            modal.classList.remove('hidden');
            
            // Mark as read if unread
            if (isRead == '0') {
                try {
                    await fetch('index.php?r=api/notifications/mark-read&id=' + notifId);
                    
                    // Update UI
                    this.classList.remove('from-indigo-50', 'to-purple-50', 'dark:from-indigo-900/20', 'dark:to-purple-900/20', 'border-indigo-200', 'dark:border-indigo-800');
                    this.classList.add('bg-gray-50', 'dark:bg-gray-700/50', 'border-gray-200', 'dark:border-gray-600');
                    this.setAttribute('data-read', '1');
                    
                    const newBadge = this.querySelector('.new-badge');
                    if (newBadge) newBadge.remove();
                    
                    const icon = this.querySelector('.iconify[data-icon*="email"]');
                    if (icon) icon.setAttribute('data-icon', 'mdi:email-open');
                    
                    const iconBg = this.querySelector('.bg-gradient-to-r');
                    if (iconBg) {
                        iconBg.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white');
                        iconBg.classList.add('bg-gray-200', 'dark:bg-gray-600', 'text-gray-600', 'dark:text-gray-300');
                    }
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            }
        });
    });
    
    function hideModal() {
        modal.classList.add('hidden');
    }
    
    if (closeModal) closeModal.addEventListener('click', hideModal);
    if (modalCloseBtn) modalCloseBtn.addEventListener('click', hideModal);
    
    // Close on overlay click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) hideModal();
    });
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            hideModal();
        }
    });
})();
</script>
