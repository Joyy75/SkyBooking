<div class="max-w-md mx-auto">
	<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-indigo-100 dark:border-gray-700">
		<div class="text-center mb-8">
			<div class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 p-4 rounded-xl mb-4 shadow-lg">
				<span class="iconify text-white text-4xl" data-icon="mdi:account-plus"></span>
			</div>
			<h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Create Account</h2>
			<p class="text-gray-600 dark:text-gray-400 mt-2">Join SkyBook and start booking flights</p>
		</div>
		
		<form method="post" action="index.php?r=auth/store" class="space-y-5">
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:account"></span>
					<span>First Name</span>
				</label>
				<input type="text" name="first_name" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="John" />
			</div>
			
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:account"></span>
					<span>Last Name</span>
				</label>
				<input type="text" name="last_name" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="Doe" />
			</div>
			
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:email"></span>
					<span>Email Address</span>
				</label>
				<input type="email" name="email" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="john@example.com" />
			</div>
			
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:lock"></span>
					<span>Password</span>
				</label>
				<input type="password" name="password" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="••••••••" />
			</div>
			
			<div>
				<label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<span class="iconify text-indigo-600 dark:text-indigo-400" data-icon="mdi:earth"></span>
					<span>Country <span class="text-gray-500 text-xs font-normal">(optional)</span></span>
				</label>
				<input type="text" name="country" class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="United States" />
			</div>
			
			<button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition">
				<span class="iconify" data-icon="mdi:account-plus"></span>
				<span>Create Account</span>
			</button>
			
			<div class="flex flex-col gap-2">
				<a href="index.php?r=auth/login" class="inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<span class="iconify" data-icon="mdi:login"></span>
					<span>Already have an account?</span>
				</a>
				<a href="index.php?r=flights/search" class="inline-flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition py-2">
					<span class="iconify" data-icon="mdi:arrow-left"></span>
					<span>Back to Home</span>
				</a>
			</div>
		</form>
	</div>
</div>
