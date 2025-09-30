-- Sample Flight Data for SkyBook (SQLite Compatible)
-- Run this in SQLite or use the admin panel to add flights

INSERT INTO flights (flight_number, origin, destination, departure_time, arrival_time, price_cents, total_seats) VALUES
-- Domestic US Flights
('AA101', 'New York (JFK)', 'Los Angeles (LAX)', '2025-10-15 08:00:00', '2025-10-15 11:30:00', 35000, 180),
('UA202', 'San Francisco (SFO)', 'Chicago (ORD)', '2025-10-16 09:30:00', '2025-10-16 15:45:00', 28000, 160),
('DL303', 'Miami (MIA)', 'Seattle (SEA)', '2025-10-17 10:00:00', '2025-10-17 13:30:00', 32000, 150),
('SW404', 'Dallas (DFW)', 'Denver (DEN)', '2025-10-18 11:15:00', '2025-10-18 12:45:00', 18000, 140),
('AA505', 'Boston (BOS)', 'Atlanta (ATL)', '2025-10-19 07:30:00', '2025-10-19 10:15:00', 22000, 170),

-- International Flights
('BA606', 'London (LHR)', 'New York (JFK)', '2025-10-20 14:00:00', '2025-10-20 17:30:00', 75000, 250),
('AF707', 'Paris (CDG)', 'Tokyo (NRT)', '2025-10-21 11:00:00', '2025-10-22 06:30:00', 95000, 300),
('EK808', 'Dubai (DXB)', 'Singapore (SIN)', '2025-10-22 03:00:00', '2025-10-22 14:30:00', 68000, 380),
('LH909', 'Frankfurt (FRA)', 'Sydney (SYD)', '2025-10-23 22:00:00', '2025-10-25 06:00:00', 125000, 340),
('QF010', 'Sydney (SYD)', 'Los Angeles (LAX)', '2025-10-24 10:00:00', '2025-10-24 06:30:00', 98000, 320),

-- Asian Routes
('SQ111', 'Singapore (SIN)', 'Hong Kong (HKG)', '2025-10-25 08:00:00', '2025-10-25 12:00:00', 35000, 280),
('CX212', 'Hong Kong (HKG)', 'Bangkok (BKK)', '2025-10-26 13:30:00', '2025-10-26 15:45:00', 28000, 200),
('TG313', 'Bangkok (BKK)', 'Mumbai (BOM)', '2025-10-27 09:00:00', '2025-10-27 11:30:00', 32000, 220),
('AI414', 'Mumbai (BOM)', 'Dubai (DXB)', '2025-10-28 16:00:00', '2025-10-28 18:30:00', 38000, 240),
('NH515', 'Tokyo (NRT)', 'Seoul (ICN)', '2025-10-29 10:30:00', '2025-10-29 13:00:00', 25000, 190),

-- European Routes
('LH616', 'Munich (MUC)', 'Rome (FCO)', '2025-10-30 07:00:00', '2025-10-30 08:45:00', 18000, 150),
('AF717', 'Paris (CDG)', 'Barcelona (BCN)', '2025-10-31 12:00:00', '2025-10-31 13:45:00', 15000, 180),
('BA818', 'London (LHR)', 'Amsterdam (AMS)', '2025-11-01 09:30:00', '2025-11-01 11:45:00', 12000, 140),
('KL919', 'Amsterdam (AMS)', 'Copenhagen (CPH)', '2025-11-02 14:00:00', '2025-11-02 15:30:00', 14000, 160),
('SK020', 'Stockholm (ARN)', 'Oslo (OSL)', '2025-11-03 08:00:00', '2025-11-03 09:15:00', 10000, 120),

-- Budget Flights
('FR121', 'London (STN)', 'Dublin (DUB)', '2025-11-04 06:00:00', '2025-11-04 07:20:00', 5000, 180),
('WZ222', 'Budapest (BUD)', 'Vienna (VIE)', '2025-11-05 11:00:00', '2025-11-05 11:50:00', 4500, 180),
('U2323', 'Berlin (TXL)', 'Prague (PRG)', '2025-11-06 15:30:00', '2025-11-06 16:45:00', 6000, 156),
('VY424', 'Madrid (MAD)', 'Lisbon (LIS)', '2025-11-07 10:00:00', '2025-11-07 10:45:00', 7500, 180),
('W6525', 'Warsaw (WAW)', 'Bucharest (OTP)', '2025-11-08 13:00:00', '2025-11-08 15:30:00', 8000, 180);
