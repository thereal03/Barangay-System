# 🌆 City-Wide Barangay Management System

<div style="text-align: center; margin: 20px 0;">
  <img src="./assets/system-banner.png" alt="System Banner" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</div>

A modern, full-stack platform connecting residents with barangay services through real-time ticketing and data-driven insights.

---

## ✨ Key Features

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 30px 0;">

<div style="background: #f8f9fa; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
<h3 style="color: #2c3e50; margin-top: 0;">🎫 Ticketing System</h3>
<p>End-to-end concern management from submission to resolution with real-time updates</p>
</div>

<div style="background: #f8f9fa; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
<h3 style="color: #2c3e50; margin-top: 0;">📊 Analytics Dashboard</h3>
<p>Interactive visualizations of ticket metrics and barangay performance</p>
</div>

<div style="background: #f8f9fa; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
<h3 style="color: #2c3e50; margin-top: 0;">👥 Role-Based Access</h3>
<p>Custom interfaces for each user type with appropriate permissions</p>
</div>

</div>

---

## 🛠️ Technology Stack

<div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 20px; margin: 30px 0;">

<div style="text-align: center;">
  <img src="https://cdn.worldvectorlogo.com/logos/laravel-2.svg" alt="Laravel" style="height: 50px; margin-bottom: 10px;">
  <p><strong>Laravel 9</strong><br>Backend Framework</p>
</div>

<div style="text-align: center;">
  <img src="https://cdn.worldvectorlogo.com/logos/vue-js-1.svg" alt="Vue.js" style="height: 50px; margin-bottom: 10px;">
  <p><strong>Vue.js 3</strong><br>Frontend Framework</p>
</div>

<div style="text-align: center;">
  <img src="https://cdn.worldvectorlogo.com/logos/mysql-6.svg" alt="MySQL" style="height: 50px; margin-bottom: 10px;">
  <p><strong>MySQL 8</strong><br>Database</p>
</div>

<div style="text-align: center;">
  <img src="https://cdn.worldvectorlogo.com/logos/aws-2.svg" alt="AWS" style="height: 50px; margin-bottom: 10px;">
  <p><strong>AWS EC2</strong><br>Hosting</p>
</div>

</div>

---

## 📖 User Manual

### 🔐 Authentication
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin: 30px 0;">
  <div style="text-align: center;">
    <img src="./User%20Manual%20Mockup/Log%20in%20page.png" alt="Login Page" style="border-radius: 8px; border: 1px solid #e1e4e8; box-shadow: 0 3px 10px rgba(0,0,0,0.08); max-width: 100%;">
    <p><strong>Login Page</strong></p>
  </div>
  <div style="text-align: center;">
    <img src="./User%20Manual%20Mockup/Recover%20Account%20Page.png" alt="Recover Account" style="border-radius: 8px; border: 1px solid #e1e4e8; box-shadow: 0 3px 10px rgba(0,0,0,0.08); max-width: 100%;">
    <p><strong>Account Recovery</strong></p>
  </div>
  <div style="text-align: center;">
    <img src="./User%20Manual%20Mockup/Change%20Password%20Page.png" alt="Change Password" style="border-radius: 8px; border: 1px solid #e1e4e8; box-shadow: 0 3px 10px rgba(0,0,0,0.08); max-width: 100%;">
    <p><strong>Password Change</strong></p>
  </div>
</div>

### 👤 Resident Portal
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin: 30px 0;">
  <div style="text-align: center;">
    <img src="./User%20Manual%20Mockup/Resident%20Home%20Page.png" alt="Resident Dashboard" style="border-radius: 8px; border: 1px solid #e1e4e8; box-shadow: 0 3px 10px rgba(0,0,0,0.08); max-width: 100%;">
    <p><strong>Dashboard View</strong></p>
  </div>
  <div style="text-align: center;">
    <img src="./User%20Manual%20Mockup/New%20Ticket%20Page.png" alt="New Ticket" style="border-radius: 8px; border: 1px solid #e1e4e8; box-shadow: 0 3px 10px rgba(0,0,0,0.08); max-width: 100%;">
    <p><strong>Ticket Submission</strong></p>
  </div>
  <div style="text-align: center;">
    <img src="./User%20Manual%20Mockup/Ticket%20Details%20Page.png" alt="Ticket Details" style="border-radius: 8px; border: 1px solid #e1e4e8; box-shadow: 0 3px 10px rgba(0,0,0,0.08); max-width: 100%;">
    <p><strong>Ticket Details</strong></p>
  </div>
</div>

[Additional sections continue with the same elegant formatting...]

---

## 🚀 Installation Guide

```bash
# Clone the repository
git clone https://github.com/your-org/barangay-system.git

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate

# Start development server
php artisan serve