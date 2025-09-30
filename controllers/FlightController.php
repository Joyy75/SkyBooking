<?php
declare(strict_types=1);

final class FlightController {
	private PDO $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function search(): void {
		$origin = $_GET['origin'] ?? '';
		$destination = $_GET['destination'] ?? '';
		$date = $_GET['date'] ?? '';
		$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
		$perPage = 5;
		
		$flightModel = new Flight($this->pdo);
		$allFlights = $flightModel->search($origin, $destination, $date);
		
		// Calculate pagination
		$totalFlights = count($allFlights);
		$totalPages = max(1, (int)ceil($totalFlights / $perPage));
		$page = min($page, $totalPages); // Don't exceed max pages
		$offset = ($page - 1) * $perPage;
		
		// Get flights for current page
		$flights = array_slice($allFlights, $offset, $perPage);
		
		view('flights/search', compact('origin', 'destination', 'date', 'flights', 'page', 'totalPages', 'totalFlights'));
	}

	public function list(): void {
		$this->search();
	}

	public function details(): void {
		$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
		$flightModel = new Flight($this->pdo);
		$bookingModel = new Booking($this->pdo);
		$flight = $flightModel->find($id);
		if (!$flight) {
			http_response_code(404);
			echo 'Flight not found';
			return;
		}
		$seatStatuses = $bookingModel->seatStatuses($id);
		view('flights/details', compact('flight', 'seatStatuses'));
	}
}


