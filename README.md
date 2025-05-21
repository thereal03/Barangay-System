# 🏙️ City-Wide Barangay Management System

![System Banner](./assets/banner.png)

A full-stack web application for managing resident concerns through real-time ticketing, analytics, and role-based access for Angeles City.

---

## 📖 User Manual with Screenshots

All screenshots are located in the `User Manual Mockup` folder:

### 🔐 Authentication
| Feature | Screenshot |
|---------|-----------|
| **Login Page** | ![Login](./User%20Manual%20Mockup/Log%20in%20page.png) |
| **Recover Account** | ![Recover](./User%20Manual%20Mockup/Recover%20Account%20Page.png) |
| **Change Password** | ![Change Pass](./User%20Manual%20Mockup/Change%20Password%20Page.png) |

### 👤 Resident Interface
| Feature | Screenshot |
|---------|-----------|
| **Home Page** | ![Resident Home](./User%20Manual%20Mockup/Resident%20Home%20Page.png) |
| **Home Page 2** | ![Resident Home 2](./User%20Manual%20Mockup/Resident%20Home%20Page%202.png) |
| **New Ticket** | ![New Ticket](./User%20Manual%20Mockup/New%20Ticket%20Page.png) |
| **Ticket Details** | ![Ticket Details](./User%20Manual%20Mockup/Ticket%20Details%20Page.png) |
| **Ticket Details 2** | ![Ticket Details 2](./User%20Manual%20Mockup/Ticket%20Details%20Page%202.png) |

### 👨‍💼 Barangay Staff Interface
| Feature | Screenshot |
|---------|-----------|
| **Ticket Management** | ![Official Ticket](./User%20Manual%20Mockup/Barangay%20Official%20Ticket%20Page.png) |
| **Ticket Management 2** | ![Official Ticket 2](./User%20Manual%20Mockup/Barangay%20Official%20Ticket%20Page%202.png) |
| **Blotter Records** | ![Blotter](./User%20Manual%20Mockup/Biotter%20Page.png) |
| **Blotter Records 2** | ![Blotter 2](./User%20Manual%20Mockup/Biotter%20Page%202.png) |
| **Service Management** | ![Service](./User%20Manual%20Mockup/Service%20Page.png) |
| **Service Management 2** | ![Service 2](./User%20Manual%20Mockup/Service%20Page%202.png) |

### 📊 Analytics Dashboard
| Feature | Screenshot |
|---------|-----------|
| **Main Dashboard** | ![Analytics 1](./User%20Manual%20Mockup/Dashboard%20Analytics%20Page.png) |
| **Dashboard 2** | ![Analytics 2](./User%20Manual%20Mockup/Dashboard%20Analytics%20Page%202.png) |
| **Dashboard 3** | ![Analytics 3](./User%20Manual%20Mockup/Dashboard%20Analytics%20Page%203.png) |
| **Dashboard 4** | ![Analytics 4](./User%20Manual%20Mockup/Dashboard%20Analytics%20Page%204.png) |
| **Dashboard 5** | ![Analytics 5](./User%20Manual%20Mockup/Dashboard%20Analytics%20Page%205.png) |

### ⚙️ Administration
| Feature | Screenshot |
|---------|-----------|
| **User Management** | ![Users](./User%20Manual%20Mockup/User%20Page.png) |
| **Barangay Settings** | ![Barangays](./User%20Manual%20Mockup/Barangays%20Page.png) |
| **Barangay Settings 2** | ![Barangays 2](./User%20Manual%20Mockup/Barangays%20Page%202.png) |
| **Announcements** | ![Announce](./User%20Manual%20Mockup/Announcement%20Page.png) |
| **Announcements 2** | ![Announce 2](./User%20Manual%20Mockup/Announcement%20Page%202.png) |
| **User Roles** | ![Roles](./User%20Manual%20Mockup/User%20Roles%20Page.png) |

### 🏷️ System Configuration
| Feature | Screenshot |
|---------|-----------|
| **Labels** | ![Labels](./User%20Manual%20Mockup/Labels%20Page.png) |
| **Labels 2** | ![Labels 2](./User%20Manual%20Mockup/Labels%20Page%202.png) |
| **Priorities** | ![Priorities](./User%20Manual%20Mockup/Priorities%20Page.png) |
| **Statuses** | ![Statuses](./User%20Manual%20Mockup/Status:%20Page.png) |
| **Canned Replies** | ![Replies](./User%20Manual%20Mockup/Canned%20Replies%20Page.png) |
| **Canned Replies 2** | ![Replies 2](./User%20Manual%20Mockup/Canned%20Replies%20Page%202.png) |

---

## 🛠️ Technical Specifications

```bash
# Installation
git clone https://github.com/your-repo/barangay-system.git
cd barangay-system
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve