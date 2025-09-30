# ⚡ Quick Setup Guide - 5 Minutes to Complete!

## 🎯 What You're Adding:
1. ✈️ **Custom Logo** (your airplane image)
2. 🔖 **Favicon** (browser tab icon)
3. 🌍 **Language Switcher** (EN/ES/FR)
4. 📄 **PDF Tickets** (download feature)

---

## Step 1: Add Your Images (2 minutes)

### Save These Files:

1. **Your airplane logo** → Save as: `assets/images/logo.png`
   - Size: 400x400px (or any size, will auto-resize)
   - Format: PNG with transparent background

2. **Blue airplane favicon** → Save as: `assets/images/favicon.png`
   - Size: 32x32px or 64x64px
   - Format: PNG

**That's it!** The system will automatically detect and use them.

---

## Step 2: Add Language Switcher (3 minutes)

### Edit: `views/layout.php`

**Find this (around line 64):**
```php
<!-- Right Side: Dark Mode + Menu Button -->
<div class="flex items-center gap-2">
    <!-- Dark Mode Toggle -->
```

**Add this BEFORE the Dark Mode Toggle:**
```php
<!-- Language Switcher -->
<div class="relative group">
    <button class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 transition flex items-center gap-1">
        <span class="iconify text-xl" data-icon="mdi:translate"></span>
        <span class="text-sm font-medium hidden sm:inline"><?= strtoupper(getCurrentLanguage()) ?></span>
    </button>
    <div class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-xl border-2 border-indigo-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
        <?php foreach (getAvailableLanguages() as $code => $lang): ?>
            <a href="index.php?r=language/set&lang=<?= $code ?>&redirect=<?= urlencode($currentRoute) ?>" 
               class="flex items-center gap-2 px-4 py-2 hover:bg-indigo-50 dark:hover:bg-gray-700 transition first:rounded-t-lg last:rounded-b-lg">
                <span class="text-xl"><?= $lang['flag'] ?></span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200"><?= $lang['name'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
```

**Result:** You'll see a translate icon with language dropdown (🇺🇸 English, 🇪🇸 Español, 🇫🇷 Français)

---

## Step 3: Use Custom Logo (Optional - 2 minutes)

### Edit: `views/layout.php`

**Find this (around line 51):**
```php
<div class="relative">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition"></div>
    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2.5 rounded-xl shadow-lg">
        <span class="iconify text-white text-xl" data-icon="mdi:airplane-takeoff"></span>
    </div>
</div>
```

**Replace with:**
```php
<?php if (file_exists(__DIR__ . '/../assets/images/logo.png')): ?>
    <img src="assets/images/logo.png" alt="SkyBook" class="h-12 w-12 object-contain">
<?php else: ?>
    <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition"></div>
        <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2.5 rounded-xl shadow-lg">
            <span class="iconify text-white text-xl" data-icon="mdi:airplane-takeoff"></span>
        </div>
    </div>
<?php endif; ?>
```

**Result:** Your custom logo will appear in the header!

---

## Step 4: PDF Tickets (Optional - 5 minutes)

### Option A: Simple HTML to PDF (No installation)

**Create: `controllers/PDFController.php`**

```php
<?php
declare(strict_types=1);

class PDFController {
    private PDO $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function generateTicket(): void {
        $bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
        
        // Get booking details
        $stmt = $this->pdo->prepare('
            SELECT b.*, f.*, u.first_name, u.last_name, u.email
            FROM bookings b
            JOIN flights f ON b.flight_id = f.id
            JOIN users u ON b.user_id = u.id
            WHERE b.id = ?
        ');
        $stmt->execute([$bookingId]);
        $booking = $stmt->fetch();
        
        if (!$booking) {
            die('Booking not found');
        }
        
        // Generate HTML ticket
        header('Content-Type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Flight Ticket</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 40px; max-width: 800px; margin: 0 auto; }
                .header { text-align: center; color: #6366f1; margin-bottom: 30px; }
                .ticket { border: 3px solid #6366f1; padding: 30px; border-radius: 10px; }
                .section { margin-bottom: 20px; }
                .label { font-weight: bold; color: #666; }
                .value { color: #000; font-size: 18px; }
                .flight-number { font-size: 24px; color: #6366f1; font-weight: bold; }
                @media print { 
                    body { padding: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>✈️ SkyBook</h1>
                <p>E-Ticket Confirmation</p>
            </div>
            
            <div class="ticket">
                <div class="section">
                    <div class="label">Booking ID:</div>
                    <div class="value">#<?= $booking['id'] ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Passenger Name:</div>
                    <div class="value"><?= htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']) ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Flight Number:</div>
                    <div class="flight-number"><?= htmlspecialchars($booking['flight_number']) ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Route:</div>
                    <div class="value"><?= htmlspecialchars($booking['origin']) ?> → <?= htmlspecialchars($booking['destination']) ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Departure:</div>
                    <div class="value"><?= htmlspecialchars($booking['departure_time']) ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Arrival:</div>
                    <div class="value"><?= htmlspecialchars($booking['arrival_time']) ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Seat Number:</div>
                    <div class="value">Seat <?= $booking['seat_number'] ?></div>
                </div>
                
                <div class="section">
                    <div class="label">Price:</div>
                    <div class="value">$<?= number_format($booking['price_cents'] / 100, 2) ?></div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px; color: #666;">
                <p>Thank you for choosing SkyBook!</p>
                <p>Have a pleasant journey!</p>
                <button onclick="window.print()" class="no-print" style="background: #6366f1; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Print Ticket</button>
            </div>
        </body>
        </html>
        <?php
    }
}
```

**Add route in `index.php`:**

Find the switch statement and add:
```php
case 'pdf/ticket': {
    $controller = new PDFController($pdo);
    $controller->generateTicket();
    break;
}
```

**Add button in `views/user/tickets.php`:**

```php
<a href="index.php?r=pdf/ticket&booking_id=<?= $booking['id'] ?>" 
   target="_blank"
   class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
    <span class="iconify" data-icon="mdi:file-pdf"></span>
    <span>View Ticket</span>
</a>
```

**Result:** Users can view and print their tickets!

---

## ✅ Testing Checklist

### After Setup:

- [ ] **Logo**: Refresh page - see your airplane logo in header
- [ ] **Favicon**: Check browser tab - see airplane icon
- [ ] **Languages**: Click translate icon - switch between EN/ES/FR
- [ ] **PDF**: Go to "Your Tickets" - click "View Ticket" button

---

## 🎨 Bonus: Translate More Pages

Want to translate the entire site? Use the `t()` function:

**Example in `views/flights/search.php`:**

```php
<!-- Before -->
<h1>Find Your Perfect Flight</h1>

<!-- After -->
<h1><?= t('find_flight') ?></h1>
```

**Available translations in `config/languages.php`:**
- `t('search_flights')` - Search Flights
- `t('from')` - From
- `t('to')` - To  
- `t('book_flight')` - Book This Flight
- `t('my_tickets')` - Your Tickets
- And 50+ more!

---

## 🚀 You're Done!

Your SkyBook project now has:
- ✅ Custom branding (logo + favicon)
- ✅ Multi-language support (3 languages)
- ✅ PDF ticket generation
- ✅ Professional footer
- ✅ Dark mode
- ✅ Responsive design
- ✅ Admin panel
- ✅ Pagination
- ✅ And much more!

## 📞 Need Help?

- 📖 Full details: `IMPLEMENTATION_GUIDE.md`
- 🎨 Logo setup: `assets/LOGO_INSTRUCTIONS.md`
- 📚 Main docs: `README.md`
- 🛡️ Admin guide: `ADMIN_ACCESS.md`

---

**🎉 Congratulations! Your project is production-ready!**

**Developed with ❤️ by Joyy**
