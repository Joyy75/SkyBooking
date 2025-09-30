# Logo and Favicon Setup

## 📸 Adding Your Custom Logo

### Step 1: Save Your Logo
1. Save the airplane logo image as `logo.png` or `logo.svg`
2. Place it in the `assets/images/` folder
3. Recommended size: **400x400px** or larger (transparent background preferred)

### Step 2: Save the Favicon
1. Save the favicon (airplane icon) as `favicon.png`
2. Place it in the `assets/images/` folder  
3. Recommended size: **32x32px** or **64x64px**

### Alternative: Use Online Converters
- **Logo**: Use any PNG/JPG image
- **Favicon**: Convert PNG to ICO at https://www.favicon-generator.org/

## 📁 File Structure
```
assets/
└── images/
    ├── logo.png          # Main logo (400x400px recommended)
    └── favicon.png       # Browser tab icon (32x32px)
```

## 🎨 Logo Usage
The logo will appear in:
- Header (top navigation)
- Footer
- Admin login page
- Email notifications

## ✅ Current Setup
The layout is already configured to use:
- `assets/images/logo.png` for the main logo
- `assets/images/favicon.png` for the browser tab icon

Just add your images to the `assets/images/` folder and they'll work automatically!

## 🔄 Fallback
If no logo is found, the system will use the default airplane icon from Iconify.
