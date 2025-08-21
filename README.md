# 🌾 Aami Shetkari - Farmer Management System

A comprehensive web-based system for farmers to manage crops, track expenses, record income, and analyze profitability.

## 🚀 Quick Start

### 1. **Prerequisites**
- XAMPP installed and running
- Apache and MySQL services started
- PHP 7.4 or higher

### 2. **Installation**
1. Place all files in your XAMPP `htdocs` folder
2. Start XAMPP Control Panel
3. Start Apache and MySQL services
4. Open your browser and go to: `http://localhost/farm/`

### 3. **First Time Setup**
- Visit `http://localhost/farm/setup.php` to create database and tables
- This will automatically set up everything you need

## 📁 File Structure

```
farm/
├── index.php          # Main dashboard
├── add_crop.php       # Add new crops
├── add_expense.php    # Record expenses
├── add_income.php     # Record income
├── report.php         # View detailed reports
├── profile.php        # User profile & statistics
├── db.php            # Database connection
├── setup.php         # Initial setup
├── test.php          # System testing
└── README.md         # This file
```

## 🎯 How to Use

### **Step 1: Add Crops**
1. Go to "Add New Crop"
2. Enter crop name, area, season, and start date
3. Click "Save Crop"

### **Step 2: Record Expenses**
1. Go to "Add Expense"
2. Select the crop from dropdown
3. Enter expense name, amount, and date
4. Click "Add Expense"

### **Step 3: Record Income**
1. Go to "Add Income"
2. Select the crop from dropdown
3. Enter income source, amount, and date
4. Click "Add Income"

### **Step 4: View Reports**
1. Go to "Reports"
2. Select a crop from dropdown
3. View detailed breakdown of income, expenses, and profit/loss
4. See charts and analysis

## 🔧 Troubleshooting

### **If the system doesn't work:**

1. **Check XAMPP:**
   - Make sure Apache and MySQL are running
   - Check XAMPP Control Panel for errors

2. **Database Issues:**
   - Visit `http://localhost/farm/setup.php`
   - This will create the database and tables

3. **Test the System:**
   - Visit `http://localhost/farm/test.php`
   - This will show you what's working and what's not

4. **Common Problems:**
   - **"Connection failed"**: Make sure MySQL is running in XAMPP
   - **"Table doesn't exist"**: Run setup.php first
   - **"Permission denied"**: Check file permissions in htdocs folder

## 📊 Features

- ✅ **Crop Management**: Add and organize crops by season
- ✅ **Expense Tracking**: Record all farming costs
- ✅ **Income Recording**: Track revenue from crops
- ✅ **Financial Reports**: Detailed profit/loss analysis
- ✅ **Charts & Graphs**: Visual representation of data
- ✅ **Mobile Responsive**: Works on all devices
- ✅ **Secure**: Protected against SQL injection

## 🌐 Access URLs

- **Main Dashboard**: `http://localhost/farm/`
- **Add Crop**: `http://localhost/farm/add_crop.php`
- **Add Expense**: `http://localhost/farm/add_expense.php`
- **Add Income**: `http://localhost/farm/add_income.php`
- **Reports**: `http://localhost/farm/report.php`
- **Profile**: `http://localhost/farm/profile.php`
- **Setup**: `http://localhost/farm/setup.php`
- **Test**: `http://localhost/farm/test.php`

## 🆘 Need Help?

1. **First**: Run `test.php` to see what's working
2. **Second**: Check XAMPP is running properly
3. **Third**: Make sure all files are in the correct folder
4. **Fourth**: Check browser console for JavaScript errors

## 🎉 Success!

When everything is working, you should see:
- ✅ Green checkmarks in the test page
- 🌾 A beautiful dashboard with statistics
- 📊 Working forms to add crops, expenses, and income
- 📈 Detailed reports with charts

---

**Made with ❤️ for Indian Farmers**
