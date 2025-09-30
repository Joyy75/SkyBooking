<?php /** @var array|null $booking */ /** @var array $flights */ ?>
<section class="card">
	<h2><?= $booking ? 'Edit Booking' : 'New Booking' ?></h2>
	<p><a href="index.php?r=admin/bookings">← Back to bookings</a></p>
	<form method="post" action="index.php?r=admin/bookings/<?= $booking ? 'update' : 'create' ?>">
		<?php if ($booking): ?><input type="hidden" name="id" value="<?= (int)$booking['id'] ?>" /><?php endif; ?>
		<label>
			<span>Flight</span>
			<select name="flight_id" required>
				<?php foreach ($flights as $f): ?>
					<option value="<?= (int)$f['id'] ?>" <?= $booking && (int)$booking['flight_id'] === (int)$f['id'] ? 'selected' : '' ?>><?= htmlspecialchars($f['flight_number']) ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>
			<span>Passenger name</span>
			<input type="text" name="passenger_name" value="<?= htmlspecialchars((string)($booking['passenger_name'] ?? '')) ?>" required />
		</label>
		<label>
			<span>Seat number (optional)</span>
			<input type="number" name="seat_number" value="<?= htmlspecialchars((string)($booking['seat_number'] ?? '')) ?>" placeholder="Leave blank for auto-assign" />
		</label>
		<div class="actions" style="margin-top:12px;">
			<button type="submit">Save</button>
			<a class="button secondary" href="index.php?r=admin/bookings">Cancel</a>
		</div>
	</form>
</section>



