<div class="max-w-md mx-auto">
	<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-indigo-100 dark:border-gray-700">
		<div class="text-center mb-8">
			
			<h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Welcome Back</h2>
			<p class="text-gray-600 dark:text-gray-400 mt-2">Login to access your account</p>
		</div>
		<form method="post" action="index.php?r=auth/authenticate" class="space-y-6">
			<div>
				<label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<i class="fas fa-envelope text-indigo-600 mr-2"></i>Email Address
				</label>
				<input type="email" name="email" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="your@email.com" />
			</div>
			<div>
				<label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
					<i class="fas fa-lock text-purple-600 mr-2"></i>Password
				</label>
				<input type="password" name="password" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="••••••••" />
			</div>
			<button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition">
				<i class="fas fa-sign-in-alt mr-2"></i>Login
			</button>
			<div class="flex gap-3">
				<a href="index.php?r=auth/register" class="flex-1 text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<i class="fas fa-user-plus mr-2"></i>Create Account
				</a>
				<a href="index.php?r=flights/search" class="flex-1 text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
					<i class="fas fa-arrow-left mr-2"></i>Back
				</a>
			</div>
		</form>
	</div>
</div>
