<div class="max-w-md mx-auto">
	<div class="bg-white dark:bg-gradient-to-br dark:from-indigo-900 dark:to-purple-900 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border-2 border-slate-200 dark:border-indigo-700">
		<div class="text-center mb-8">
			<div class="inline-block bg-gradient-to-r from-slate-700 to-slate-900 dark:from-indigo-600 dark:to-purple-600 p-4 rounded-xl mb-4 shadow-lg">
				<span class="iconify text-white text-4xl" data-icon="mdi:shield-lock"></span>
			</div>
			<h2 class="text-3xl font-bold text-slate-800 dark:text-white">Admin Access</h2>
			<p class="text-gray-600 dark:text-indigo-200 mt-2">Enter admin password to continue</p>
		</div>
		<form method="post" action="index.php?r=admin/auth" class="space-y-6">
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-indigo-200 mb-2">
					<span class="iconify text-slate-700 dark:text-indigo-300" data-icon="mdi:lock"></span>
					<span>Admin Password</span>
				</label>
				<input type="password" name="password" required class="w-full px-4 py-3 bg-white dark:bg-indigo-950/50 text-gray-900 dark:text-white border border-gray-300 dark:border-indigo-700 rounded-lg focus:ring-2 focus:ring-slate-500 dark:focus:ring-indigo-400 focus:border-transparent transition" placeholder="••••••••" />
			</div>
			<button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-slate-700 to-slate-900 dark:from-indigo-600 dark:to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition">
				<span class="iconify" data-icon="mdi:login"></span>
				<span>Sign In</span>
			</button>
			<a href="index.php?r=flights/search" class="inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-indigo-800/50 text-gray-700 dark:text-indigo-100 px-4 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-indigo-700 transition w-full">
				<span class="iconify" data-icon="mdi:arrow-left"></span>
				<span>Back to Home</span>
			</a>
		</form>
	</div>
</div>



