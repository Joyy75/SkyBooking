# 🚀 Advanced Features Implementation Guide

## ✅ What's Already Done

### 1. ✨ Multi-Language System (COMPLETED)
- ✅ Created `config/languages.php` with English, Spanish, and French translations
- ✅ Added language route handler in `index.php`
- ✅ Translation function `t()` ready to use
- ✅ Language switcher dropdown ready

### 2. 📁 Assets Folder Structure (COMPLETED)
- ✅ Created `assets/images/` folder
- ✅ Logo and favicon support added to layout
- ✅ Instructions file created: `assets/LOGO_INSTRUCTIONS.md`

## 🔧 Implementation Steps

### Step 1: Add Your Logo and Favicon

**Save these images:**
1. **Logo**: Save your airplane logo as `assets/images/logo.png` (400x400px recommended)
2. **Favicon**: Save the blue airplane icon as `assets/images/favicon.png` (32x32px)

The system will automatically detect and use them!

### Step 2: Add Language Switcher to Header

**Edit `views/layout.php` around line 64-70:**

Find this section:
```php
<!-- Right Side: Dark Mode + Menu Button -->
<div class="flex items-center gap-2">
    <!-- Dark Mode Toggle -->
    <button id="theme-toggle" class="p-2 rounded-lg...">
```

**Replace with:**
```php
<!-- Right Side: Language + Dark Mode + Menu Button -->
<div class="flex items-center gap-2">
    <!-- Language Switcher -->
    <div class="relative group">
        <button class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-800 transition flex items-center gap-1">
            <span class="iconify text-xl" data-icon="mdi:translate"></span>
            <span class="text-sm font-medium hidden sm:inline"><?= strtoupper(getCurrentLanguage()) ?></span>
        </button>
        <div class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-xl border-2 border-indigo-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <?php foreach (getAvailableLanguages() as $code => $lang): ?>
                <a href="index.php?r=language/set&lang=<?= $code ?>&redirect=<?= urlencode($currentRoute) ?>" 
                   class="flex items-center gap-2 px-4 py-2 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                    <span class="text-xl"><?= $lang['flag'] ?></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200"><?= $lang['name'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Dark Mode Toggle -->
    <button id="theme-toggle" class="p-2 rounded-lg...">
```

### Step 3: Update Logo in Header

**Edit `views/layout.php` around line 51-61:**

Find:
```php
<!-- Logo & Brand -->
<a href="index.php?r=flights/search" class="flex items-center space-x-3 group">
    <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition"></div>
        <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2.5 rounded-xl shadow-lg">
            <span class="iconify text-white text-xl" data-icon="mdi:airplane-takeoff"></span>
        </div>
    </div>
    <div class="flex flex-col">
        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">SkyBook</span>
        <span class="text-xs text-gray-500 dark:text-gray-400 -mt-1">Book Your Journey</span>
    </div>
</a>
```

**Replace with:**
```php
<!-- Logo & Brand -->
<a href="index.php?r=flights/search" class="flex items-center space-x-3 group">
    <?php if (file_exists(__DIR__ . '/../assets/images/logo.png')): ?>
        <img src="assets/images/logo.png" alt="<?= t('site_name') ?>" class="h-12 w-12 object-contain">
    <?php else: ?>
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition"></div>
            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2.5 rounded-xl shadow-lg">
                <span class="iconify text-white text-xl" data-icon="mdi:airplane-takeoff"></span>
            </div>
        </div>
    <?php endif; ?>
    <div class="flex flex-col">
        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"><?= t('site_name') ?></span>
        <span class="text-xs text-gray-500 dark:text-gray-400 -mt-1"><?= t('site_tagline') ?></span>
    </div>
</a>
```

### Step 4: Use Translations in Your Pages

**Example - Update `views/flights/search.php`:**

Replace hardcoded text with translation functions:

```php
<!-- Before -->
<h1 class="text-4xl font-bold text-white mb-2">Find Your Perfect Flight</h1>

<!-- After -->
<h1 class="text-4xl font-bold text-white mb-2"><?= t('find_flight') ?></h1>
```

**Common translations:**
- `t('search_flights')` - "Search Flights"
- `t('from')` - "From"
- `t('to')` - "To"
- `t('date')` - "Date"
- `t('available_flights')` - "Available Flights"
- `t('book_flight')` - "Book This Flight"

## 📄 PDF Ticket Generation

### Option 1: Using TCPDF Library (Recommended)

**Step 1: Install TCPDF**
```bash
composer require tecnickcom/tcpdf
```

**Step 2: Create PDF Controller**

Create `controllers/PDFController.php`:

```php
<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

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
        
        // Create PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
        $pdf->SetCreator('SkyBook');
        $pdf->SetAuthor('SkyBook');
        $pdf->SetTitle('Flight Ticket');
        
        $pdf->AddPage();
        
        // Header
        $pdf->SetFont('helvetica', 'B', 24);
        $pdf->SetTextColor(99, 102, 241); // Indigo
        $pdf->Cell(0, 15, 'SkyBook', 0, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(107, 114, 128); // Gray
        $pdf->Cell(0, 5, 'E-Ticket Confirmation', 0, 1, 'C');
        $pdf->Ln(10);
        
        // Booking Info
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 8, 'Booking Confirmation', 0, 1);
        $pdf->Ln(2);
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 6, 'Booking ID:', 0, 0);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 6, '#' . $booking['id'], 0, 1);
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 6, 'Passenger:', 0, 0);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 6, $booking['first_name'] . ' ' . $booking['last_name'], 0, 1);
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 6, 'Email:', 0, 0);
        $pdf->Cell(0, 6, $booking['email'], 0, 1);
        $pdf->Ln(5);
        
        // Flight Details
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 8, 'Flight Details', 0, 1);
        $pdf->Ln(2);
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 6, 'Flight Number:', 0, 0);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 6, $booking['flight_number'], 0, 1);
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 6, 'From:', 0, 0);
        $pdf->Cell(0, 6, $booking['origin'], 0, 1);
        
        $pdf->Cell(50, 6, 'To:', 0, 0);
        $pdf->Cell(0, 6, $booking['destination'], 0, 1);
        
        $pdf->Cell(50, 6, 'Departure:', 0, 0);
        $pdf->Cell(0, 6, $booking['departure_time'], 0, 1);
        
        $pdf->Cell(50, 6, 'Arrival:', 0, 0);
        $pdf->Cell(0, 6, $booking['arrival_time'], 0, 1);
        
        $pdf->Cell(50, 6, 'Seat Number:', 0, 0);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 6, 'Seat ' . $booking['seat_number'], 0, 1);
        
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 6, 'Price:', 0, 0);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 6, '$' . number_format($booking['price_cents'] / 100, 2), 0, 1);
        $pdf->Ln(10);
        
        // Footer
        $pdf->SetFont('helvetica', 'I', 9);
        $pdf->SetTextColor(107, 114, 128);
        $pdf->Cell(0, 5, 'Thank you for choosing SkyBook!', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Have a pleasant journey!', 0, 1, 'C');
        
        // Output PDF
        $pdf->Output('ticket_' . $bookingId . '.pdf', 'D');
    }
}
```

**Step 3: Add Route**

In `index.php`, add:
```php
case 'pdf/ticket': {
    $controller = new PDFController($pdo);
    $controller->generateTicket();
    break;
}
```

**Step 4: Add Download Button**

In `views/user/tickets.php`, add:
```php
<a href="index.php?r=pdf/ticket&booking_id=<?= $booking['id'] ?>" 
   class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
    <span class="iconify" data-icon="mdi:file-pdf"></span>
    <span>Download PDF</span>
</a>
```

### Option 2: Using DomPDF (Alternative)

**Install:**
```bash
composer require dompdf/dompdf
```

**Usage:**
```php
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$html = '<h1>Flight Ticket</h1><p>Booking ID: ' . $bookingId . '</p>';
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('ticket.pdf');
```

## 🎨 Logo Best Practices

### Recommended Sizes:
- **Header Logo**: 48x48px to 64x64px
- **Footer Logo**: 32x32px to 48x48px
- **Favicon**: 32x32px or 64x64px
- **Source File**: 400x400px or larger (for future use)

### File Formats:
- **PNG** with transparent background (recommended)
- **SVG** for scalability
- **ICO** for favicon (optional)

### Color Schemes:
Your airplane logo colors:
- Orange: `#FF8C42`
- Blue/Teal: `#2C7A7B`
- Sky Blue: `#56CCF2`

## ✅ Testing Checklist

### Multi-Language:
- [ ] Language switcher appears in header
- [ ] Clicking language changes text
- [ ] Language persists across pages
- [ ] All 3 languages work (EN, ES, FR)

### Logo & Favicon:
- [ ] Logo appears in header
- [ ] Logo appears in footer
- [ ] Favicon shows in browser tab
- [ ] Logo is clear on both light/dark modes

### PDF Tickets:
- [ ] PDF downloads successfully
- [ ] All booking details are correct
- [ ] PDF is properly formatted
- [ ] Logo appears in PDF (if added)

## 📚 Additional Resources

### Composer (for PDF libraries):
Download from: https://getcomposer.org/

### Image Optimization:
- TinyPNG: https://tinypng.com/
- Squoosh: https://squoosh.app/

### Favicon Generator:
- https://www.favicon-generator.org/
- https://realfavicongenerator.net/

## 🎯 Next Steps

1. **Add your logo and favicon** to `assets/images/`
2. **Update header** with language switcher code
3. **Install Composer** and TCPDF for PDF generation
4. **Test all features** in both light and dark modes
5. **Translate more pages** using `t()` function

---

**Need Help?**
- Check `config/languages.php` for available translations
- See `assets/LOGO_INSTRUCTIONS.md` for logo setup
- Review this guide for step-by-step instructions

**Developed with ❤️ by Joyy**
