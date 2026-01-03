<p align="center">
  <img src="assets/img/favicon.png" width="120" alt="TMS Logo" />
</p>

<h1 align="center">Transportation Management System (TMS)</h1>

<p align="center">
  A prototype for carrier-facility synchronization and real-time shipment lifecycle management.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Backend-PHP_8-777BB4" />
  <img src="https://img.shields.io/badge/Database-SQLite3-003B57" />
  <img src="https://img.shields.io/badge/Frontend-Bootstrap_5-7952B3" />
  <img src="https://img.shields.io/badge/Analytics-Chart.js-FF6384" />
  <img src="https://img.shields.io/badge/Workflow-Automated-blue" />
</p>

**Transportation Management system** is a full-stack TMS designed to bridge the visibility gap between logistics providers and third-party carriers. It transforms manual yard management into a data-driven operation, focusing on driver accountability, asset uptime, and facility throughput.

<p align="center">
  <a href="https://tms.ronbodnar.com" target="_blank">
    <img src="https://img.shields.io/badge/Launch_Demo-blue?style=for-the-badge" alt="Launch Demo" />
  </a>
</p>

<br />

## 📍 Table of Contents

- [🚀 Vision](#vision)
- [🧠 Operational Workflows](#workflows)
- [🏗️ Technical Architecture](#architecture)
- [📊 Analytical Insights](#analytics)
- [🚦 Getting Started](#getting-started)

<br />

<a name="vision"></a>

## 🚀 Vision

I built this system while working as a driver after seeing the constant friction between logistics staff and carriers. Inefficiencies weren't just about data; they were about accountability. When "missed messages" and "lost paperwork" become the standard excuse for delays, the whole yard slows down.

This TMS removes the "he-said, she-said" by creating a definitive, timestamped digital record of every assignment, refusal, and handoff.

<br />

<a name="workflows"></a>

## 🧠 Operational Workflows

- **Dynamic Asset Orchestration**: Real-time reassignment of drivers to specific facility doors and yard locations based on priority.
- **Out-of-Service (OOS) Lifecycle**: Integrated maintenance workflow where refused loads automatically trigger trailer OOS status and task assignment for repairs.
- **Chain of Custody**: Seamless shipment handoffs between drivers with digital "paper trails" and BOL image integration.
- **Logistics Pause & Divert**: Advanced driver controls for facility stops and shipment pausing, reflecting real-world road conditions and scheduling shifts.
- **Goal-Driven Operations**: Automated monitoring of facility-specific shipment targets to ensure daily KPIs are met.

<br />

<a name="architecture"></a>

## 🏗️ Technical Architecture

### Data Persistence Layer

- **SQLite3 Integration**: Utilized for low-latency, file-based relational storage, ideal for high-speed local processing of yard moves and logs.
- **Relational Schema**: Designed to handle complex many-to-many relationships between drivers, trailers, and multi-stop shipments.

### Frontend Engine

- **Data-Heavy UI**: Leveraging **DataTables** and **jQuery** for high-density information display, allowing dispatchers to filter thousands of records instantly.
- **Responsive Management**: A Mobile-First approach for driver inputs (refusals, handoffs) combined with a Desktop-First dashboard for facility managers.

<br />

<a name="analytics"></a>

## 📊 Analytical Insights

The system doesn't just store data; it interprets it to reduce "dwell time" (wait times at facilities):

- **Throughput Monitoring**: Visualizing shipments per month to identify seasonal peaks.
- **Bottleneck Identification**: Real-time tracking of facility wait times to optimize door assignments.

<br />

<a name="getting-started"></a>

## 🚦 Getting Started

### Prerequisites

- **PHP 8.0+**
- **SQLite3 PHP Extension** (Usually included by default, ensure it's enabled in `php.ini`)

### Installation & Setup

1. **Clone the repository**

```bash
git clone https://github.com/ronbodnar/tms-prototype.git
cd tms-prototype
```

2. **Set Permissions**

The web server needs write access to the SQLite database file and the directory it sits in.

```bash
chmod -R 775 data/
chmod 664 data/tms.db
```

3. **Run the Application**

For local development, you can use the built-in PHP server:

```bash
php -S localhost:8000
```

Open `http://localhost:8000` in your browser.

Alternatively, move the files to your web server root (e.g., `/var/www/html` or XAMPP's `htdocs`).

<br />

## 📫 Connect

**Created by Ron Bodnar**

- LinkedIn: [linkedin.com/in/ronbodnar](https://linkedin.com/in/ronbodnar)
- Portfolio: [ronbodnar.com](https://ronbodnar.com)

<br />

## ⚖️ License

Distributed under the MIT License. See `LICENSE` for more information.
