# 🛡️ Admin Panel Access Guide

## 🔐 How to Access Admin Panel

### Method 1: Direct URL
Simply navigate to:
```
http://localhost:8000/index.php?r=admin
```

### Method 2: From Any Page
Add `?r=admin` to the URL:
```
index.php?r=admin
```

## 🔑 Admin Login

**Default Admin Password:** `admin123`

### Change Admin Password
Edit `config/database.php`:
```php
define('ADMIN_PASSWORD', 'your_new_secure_password');
```

## 📊 Admin Features

### Dashboard
- 📈 **Statistics Overview** - Total flights and bookings
- 🎨 **Colorful Cards** - Beautiful gradient designs
- ⚡ **Quick Actions** - Fast access to main features

### Manage Flights
- ✈️ **Add New Flight** - Beautiful form with datetime pickers
- ✏️ **Edit Flight** - Update flight details
- 🗑️ **Delete Flight** - Remove flights from system
- 📱 **Responsive Views**:
  - Desktop: Table view with all details
  - Mobile: Card view with touch-friendly buttons

### View Bookings
- 📋 **All Reservations** - Complete booking list
- ✅ **Confirm Bookings** - Approve pending bookings
- 👤 **Passenger Details** - View customer information
- 💺 **Seat Information** - Track seat assignments

### Manage Users
- 👥 **User List** - All registered users
- 📧 **Contact Info** - Email addresses
- 📅 **Registration Dates** - User signup tracking
- 🌍 **User Countries** - Geographic data

## 🎨 Admin Panel Design

### Light Mode
- 🌈 Colorful gradient cards (Indigo, Purple, Pink, Green)
- ✨ Clean white backgrounds
- 🎯 High contrast for readability
- 💫 Professional appearance

### Dark Mode
- 🌙 Elegant gray/slate theme
- 💜 Indigo/purple accents
- 👁️ Easy on the eyes
- 🎨 Consistent color scheme

### Responsive Design
- 📱 **Mobile**: Card layouts, stacked forms
- 💻 **Desktop**: Full tables, multi-column grids
- 🎯 **Touch-Friendly**: Large buttons and spacing

## 🔒 Security Features

- 🔐 **Password Protection** - Secure admin access
- 🚫 **Hidden from Users** - No sidebar link for regular users
- 🔑 **Session Management** - Secure login sessions
- 🛡️ **Direct URL Only** - Must know the admin URL

## 📝 Managing Flights

### Add New Flight
1. Click "Manage Flights" on dashboard
2. Click "Add New Flight" button
3. Fill in the form:
   - Flight Number (e.g., AA101)
   - Origin (e.g., New York (JFK))
   - Destination (e.g., Los Angeles (LAX))
   - Departure Time (use datetime picker)
   - Arrival Time (use datetime picker)
   - Price in cents (e.g., 35000 = $350.00)
   - Total Seats (e.g., 180)
4. Click "Save Flight"

### Import Sample Flights
Use `sample_flights.sql` with 25 pre-made flights:

**Option 1: DB Browser for SQLite**
1. Download from https://sqlitebrowser.org/
2. Open `data/app.db`
3. Go to "Execute SQL" tab
4. Paste contents from `sample_flights.sql`
5. Click "Execute"

**Option 2: Manual Entry**
Use the admin panel to add flights one by one with the beautiful form interface.

### Sample Flight Categories
- ✈️ **Domestic US** - 5 flights
- 🌍 **International** - 5 long-haul flights
- 🗺️ **Asian Routes** - 5 flights
- 🇪🇺 **European Routes** - 5 flights
- 💰 **Budget Airlines** - 5 low-cost flights

## 🎯 Best Practices

### Flight Management
- ✅ Use realistic flight numbers (e.g., AA101, UA202)
- ✅ Include airport codes in city names
- ✅ Set reasonable prices (in cents)
- ✅ Choose appropriate seat counts (120-380)
- ✅ Ensure departure is before arrival

### Booking Management
- ✅ Confirm bookings promptly
- ✅ Check seat availability
- ✅ Verify passenger details
- ✅ Monitor booking patterns

### User Management
- ✅ Review new registrations
- ✅ Monitor user activity
- ✅ Respect user privacy
- ✅ Keep data secure

## 🚀 Quick Tips

1. **Logout**: Always logout when done
2. **Mobile Access**: Admin panel works great on phones
3. **Dark Mode**: Toggle anytime in header
4. **Navigation**: Use "Dashboard" button to return home
5. **Responsive**: Resize browser to see mobile view

## 📞 Need Help?

- 📧 Email: support@skybook.com
- 📖 Check README.md for full documentation
- 🐛 Report issues in the repository

---

**Developed with ❤️ by Joyy**
