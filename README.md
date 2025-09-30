# ✈️ SkyBook - Professional Flight Booking System

<div align="center">

![SkyBook](https://img.shields.io/badge/SkyBook-Flight%20Booking-6366f1?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite)
![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)

**A modern, full-featured flight booking system with beautiful UI/UX**

[Features](#-features) • [Installation](#-installation) • [Screenshots](#-screenshots) • [Tech Stack](#-tech-stack) • [License](#-license)

</div>

---

## 🌟 Features

### 🎨 **Modern UI/UX**
- ✨ Beautiful gradient designs with glassmorphism effects
- 🌓 **Full Dark Mode Support** - Seamless theme switching
- 📱 **Fully Responsive** - Perfect on mobile, tablet, and desktop
- 🎭 Smooth animations and transitions
- 🎨 Professional color schemes (Indigo, Purple, Pink gradients)

### 👤 **User Features**
- 🔐 Complete authentication system (Register, Login, Logout)
- 🔍 Advanced flight search with filters
- 📄 **Pagination** - 5 flights per page with beautiful navigation
- 💺 Interactive seat selection with visual seat map
- 🎫 Booking management - View all your tickets
- 🔔 Real-time notifications system
- 👤 User profile with avatar upload
- 🌍 Country selection

### 🛫 **Flight Management**
- ✈️ Real-time seat availability
- 🗺️ Visual airplane seat layout
- 📊 Flight details with origin/destination
- ⏰ Departure and arrival times
- 💰 Dynamic pricing
- 🎟️ Booking confirmation system

### 🛡️ **Admin Panel**
- 🔒 Secure admin authentication
- 📊 Dashboard with statistics
- ✈️ Flight management (Add, Edit, Delete)
- 📋 Booking management
- 👥 User management
- 📱 Mobile-responsive admin interface
- 🌈 Colorful stats cards
- 🎨 Beautiful form designs

### 🎯 **Additional Features**
- 🔄 No sidebar on admin pages (clean interface)
- 🌍 **Multi-Language Support** - English, Spanish, French
- 🎨 **Custom Logo Support** - Use your own branding
- 🔖 **Favicon** - Custom browser tab icon
- 📄 **PDF Ticket Generation** - Download tickets as PDF
- 📧 Email notifications (simulated)
- 🌐 Social media integration
- 📞 Contact information
- 💝 Professional footer with "Developed by Joyy"
- 🎨 Custom icons using Iconify
- ⚡ Fast SQLite database
- 🔐 Secure password hashing

---

## 🚀 Installation

### Prerequisites
- PHP 8.1 or higher
- PDO SQLite extension enabled
- Web server (Apache/Nginx) or PHP built-in server

### Quick Start

1. **Clone or Download the project**
   ```bash
   cd AirTicketBooking
   ```

2. **Start the server**
   ```bash
   php -S localhost:8000
   ```

3. **Open in browser**
   ```
   http://localhost:8000/index.php
   ```

4. **Default Admin Access**
   - URL: `http://localhost:8000/index.php?r=admin`
   - Password: `admin123`

### Adding Sample Flights

The database comes with 4 default flights. To add 25 more sample flights:

1. Download **DB Browser for SQLite** from https://sqlitebrowser.org/
2. Open `data/app.db`
3. Go to "Execute SQL" tab
4. Copy contents from `sample_flights.sql`
5. Execute the SQL

**OR** use the Admin Panel to add flights manually.

### Advanced Features Setup

For **Multi-Language**, **Custom Logo**, **Favicon**, and **PDF Tickets**:

📖 **See `IMPLEMENTATION_GUIDE.md` for detailed instructions**

Quick steps:
1. **Logo**: Add `assets/images/logo.png` (your airplane image)
2. **Favicon**: Add `assets/images/favicon.png` (browser tab icon)
3. **Languages**: Already configured! Just add the language switcher to header
4. **PDF**: Install Composer and TCPDF library (instructions in guide)

---

## 📸 Screenshots

### User Interface
- 🏠 **Home Page** - Beautiful hero section with flight search
- 🔍 **Search Results** - Paginated flight listings with filters
- 💺 **Seat Selection** - Interactive airplane seat map
- 🎫 **My Tickets** - View all bookings
- 🔔 **Notifications** - Real-time alerts
- 👤 **Profile** - User dashboard with avatar

### Admin Interface
- 📊 **Dashboard** - Stats overview with colorful cards
- ✈️ **Manage Flights** - Table view (desktop) / Card view (mobile)
- 📝 **Add/Edit Flight** - Beautiful form with datetime pickers
- 📋 **Bookings** - Manage all reservations
- 👥 **Users** - View registered users

---

## 🛠️ Tech Stack

### Backend
- **PHP 8.1+** - Modern PHP with strict types
- **SQLite** - Lightweight, serverless database
- **PDO** - Secure database access
- **Custom Router** - Clean URL routing

### Frontend
- **TailwindCSS** - Utility-first CSS framework
- **Iconify** - Modern icon system (Material Design Icons)
- **Vanilla JavaScript** - No framework dependencies
- **CSS Gradients** - Beautiful color schemes

### Design
- **Glassmorphism** - Modern frosted glass effects
- **Dark Mode** - Complete theme support
- **Responsive Design** - Mobile-first approach
- **Animations** - Smooth transitions

---

## 📁 Project Structure

```
AirTicketBooking/
├── config/
│   ├── config.php          # Configuration constants
│   └── database.php        # Database connection & schema
├── controllers/
│   ├── AdminController.php # Admin panel logic
│   ├── AuthController.php  # Authentication
│   ├── BookingController.php
│   ├── FlightController.php
│   └── UserController.php
├── models/
│   ├── Booking.php         # Booking model
│   ├── Flight.php          # Flight model
│   ├── Notification.php    # Notifications
│   └── User.php            # User model
├── views/
│   ├── admin/              # Admin panel views
│   ├── auth/               # Login, Register, Profile
│   ├── bookings/           # Booking pages
│   ├── flights/            # Flight search & details
│   ├── user/               # User dashboard
│   └── layout.php          # Main layout template
├── data/
│   └── app.db              # SQLite database
├── uploads/                # User avatars
├── index.php               # Front controller & router
├── sample_flights.sql      # Sample data (25 flights)
├── ADMIN_ACCESS.md         # Admin documentation
└── README.md               # This file
```

---

## 🎯 Key Features Explained

### Pagination System
- Shows 5 flights per page
- Beautiful page number navigation
- Previous/Next buttons
- Shows "X of Y flights"
- Maintains search filters across pages

### Seat Selection
- Visual airplane layout
- Color-coded seats (Available, Pending, Booked)
- Interactive click-to-select
- Real-time availability
- Prevents double booking

### Dark Mode
- Persistent theme preference
- Smooth transitions
- All pages fully supported
- Toggle in header

### Responsive Design
- Mobile: Card layouts, stacked forms
- Tablet: Optimized spacing
- Desktop: Full table views, multi-column grids

---

## 🔐 Security Features

- ✅ Password hashing with `password_hash()`
- ✅ Prepared statements (SQL injection prevention)
- ✅ XSS protection with `htmlspecialchars()`
- ✅ CSRF protection ready
- ✅ Session management
- ✅ Admin password protection

---

## 🎨 Customization

### Change Colors
Edit the gradient colors in `views/layout.php`:
```php
from-indigo-600 to-purple-600  // Change to your brand colors
```

### Change Admin Password
Edit `config/database.php`:
```php
define('ADMIN_PASSWORD', 'your_new_password');
```

### Add More Features
- Payment gateway integration
- Email notifications (SMTP)
- PDF ticket generation
- Flight status tracking
- Multi-language support

---

## 📝 License

This project is open source and available for personal and commercial use.

---

## 👨‍💻 Developer

**Developed with ❤️ by Joyy**

A modern, professional flight booking system showcasing:
- Clean code architecture
- Beautiful UI/UX design
- Responsive layouts
- Dark mode implementation
- Real-world features

---

## 🙏 Acknowledgments

- **TailwindCSS** - For the amazing utility-first CSS framework
- **Iconify** - For the beautiful icon system
- **PHP Community** - For excellent documentation

---

## 📞 Support

For questions or issues:
- 📧 Email: support@skybook.com
- 🐛 Issues: Create an issue in the repository
- 💬 Discussions: Open a discussion

---

<div align="center">

**⭐ Star this project if you found it helpful!**

Made with 💜 by **Joyy**

</div>

