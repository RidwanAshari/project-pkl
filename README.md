# Asset Management System

Enterprise-grade asset lifecycle management system built on **Laravel 10** for centralized asset tracking, transfer workflow, maintenance scheduling, and reporting.

---

## Executive Summary

The Asset Management System is a web-based platform that manages the complete lifecycle of organizational assets — from acquisition to disposal. It standardizes data, enforces approval workflows, and provides traceable audit logs to support operations, finance, and compliance teams.

**Key Capabilities**
- Central asset registry with detailed metadata  
- QR-based digital identification for fast lookup  
- Transfer workflow with approvals and Berita Acara (BA) generation  
- Maintenance scheduling (preventive / corrective / predictive)  
- Reporting & analytics for asset valuation, movement, and condition  

---

## System Overview

### Purpose & Vision
Provide a unified digital platform to efficiently manage, track, and optimize assets across locations, departments, and users.

### Target Users
- Asset Managers (main admins)  
- Department Heads (unit-level management)  
- End Users / Asset Holders  
- Auditors (internal/external)  
- IT Administrators (infra & support)  

### Key Benefits
- ±50% reduction in time spent on asset tracking  
- Real-time visibility of asset status and location  
- Automated documentation for audits and compliance  
- Better maintenance decisions through structured data  
- Centralized, queryable history (movement, value, condition)  

---

## Architecture & Technology Stack

### Layered Architecture
**Presentation Layer**
- Blade Templates  
- Bootstrap 5.3  
- JavaScript Components  

**Application Layer**
- Controllers  
- Service Classes  
- Form Requests  
- Middleware  

**Domain Layer**
- Eloquent Models  
- Repository Pattern  
- Business Logic  
- Validation Rules  

**Infrastructure Layer**
- MySQL (Primary Database)  
- File Storage  
- Redis Cache  
- Queue System  

### Technology Stack
- **Backend:** PHP 8.1+, Laravel 10.x  
- **Frontend:** Blade, Bootstrap 5.3, Vanilla JS  
- **Database:** MySQL 8.0+ (or compatible)  
- **Cache / Queue:** Redis 6.0+  
- **Web Server:** Nginx / Apache  
- **Tooling:** Composer 2.x, Node.js 16+  

---

## Core Features

### 1. Asset Registration & Cataloging

**Asset Types**
- Fixed Assets  
- Movable Assets  
- Vehicles  
- IT Assets  
- Intangible Assets  

**Key Fields**
- **Basic:** Code, Name, Category  
- **Technical:** Model, Serial, Specifications  
- **Financial:** Cost, Depreciation, Current Value  
- **Physical:** Dimensions, Weight, Condition  
- **Location & Custody:** Holder, Location, Status  

---

### 2. Digital Identification (QR Code)
- Unique QR code per asset (encrypted key / ID)  
- Stored in database and printable for physical labeling  
- Scannable via mobile/web for instant asset lookup  
- Supports bulk QR generation for asset batches  

---

### 3. Transfer Management
- **Initiation:** request, current holder verification, document upload  
- **Approval:** department head + asset manager + compliance check  
- **Execution:** physical handover, digital acknowledgement, BA generation  
- **Completion:** database update, notifications, audit trail  

**Automated Documents**
- BA Transfer  
- Receipt/Release Forms  
- Asset Condition Reports  

---

### 4. Maintenance Module
- **Types:** Preventive, Corrective, Predictive, Emergency  
- **Scheduling Based On:** last maintenance, usage hours, condition score  
- **Records:** service history, maintenance cost, vendor/mechanic notes  
- **Reminders:** upcoming/overdue maintenance notifications  

---

### 5. Reporting & Analytics

**Standard Reports**
- Asset Register  
- Valuation & Depreciation  
- Maintenance History  
- Transfer Logs  
- Condition Overview  

**Advanced Capabilities**
- Filters & Ad-hoc Data Queries  
- Export Formats: PDF, Excel, CSV  
- Dashboard with KPIs (by category, location, status, etc.)  

---

## Implementation Roadmap (High-Level)

### Phase 1 — Foundation (Weeks 1–4)
- Environment setup and deployment  
- Database design & migrations  
- Authentication & RBAC  
- Asset CRUD modules  
- Dashboard and asset search  
- Initial QR integration  
- Basic reporting  
- Unit tests, performance tuning, security checks  

### Phase 2 — Enhancement (Weeks 5–8)
- Full transfer workflow + approvals + BA documents  
- Maintenance module (scheduling, costs, history, reminders)  
- Reporting engine (custom builder, scheduling, exports)  
- External integrations (if required)  
- Responsive layout optimization  
- Final UAT and production rollout  
