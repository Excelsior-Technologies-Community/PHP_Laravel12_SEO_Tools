# PHP_Laravel12_SEO_Tools
## Overview

Laravel SEO Tools Project is a comprehensive SEO management system built with Laravel 12.
It provides page auditing, sitemap generation, robots.txt management, and SEO performance tracking in a single dashboard.

The system helps developers and website owners optimize web pages, monitor SEO metrics, and maintain search engine visibility.

---

## Features

### Core Functionalities

* SEO Page Management – Create, Read, Update, Delete SEO‑optimized pages
* Automated SEO Auditing – Analyze meta tags, content quality, and performance metrics
* Sitemap Generator – Automatic XML sitemap creation with dynamic URLs
* Robots.txt Management – Generate and customize robots.txt files
* Audit History – Track SEO performance changes over time
* Dashboard Analytics – Visual overview of SEO scores and metrics

### Technical Features

* Laravel 12 MVC Architecture
* MySQL Database with Eloquent ORM
* Bootstrap 5 Responsive Interface
* Spatie Laravel Sitemap Package Integration
* RESTful API Design
* Service Layer for Business Logic Separation

---

## Prerequisites

* PHP 8.2 or Higher
* Composer
* MySQL 5.7 or Higher
* Node.js and NPM (Optional for Frontend Assets)

---

## Installation

### Step 1: Clone and Setup

```bash
git clone https://github.com/your-username/laravel-seo-tools-project.git
cd laravel-seo-tools-project
composer install
cp .env.example .env
php artisan key:generate
```

### Step 2: Configure Database

Edit `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seo_tools
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://127.0.0.1:8000
```

Create database manually in MySQL, then run:

```bash
php artisan migrate
```

### Step 3: Install Dependencies

```bash
composer require spatie/laravel-sitemap
```

### Step 4: Run Development Server

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000
```

---

## Project Structure

```
laravel-seo-tools-project/
app/
  Models/
    SeoPage.php
    SeoAuditLog.php
  Http/Controllers/
    SeoPageController.php
    SeoAuditController.php
    SitemapController.php
    RobotsController.php
  Services/
    SeoAnalyzerService.php
database/
  migrations/
resources/
  views/
routes/
public/
  sitemap.xml
  robots.txt
```

---

## Database Schema

### SeoPages Table

* page_url
* page_title
* meta_description
* meta_keywords
* og_title
* og_description
* og_image
* canonical_url
* json_ld
* h1_tag
* h2_tags
* word_count
* image_count
* internal_links
* external_links
* performance_score

### SeoAuditLogs Table

* seo_page_id
* audit_type
* audit_data (JSON)
* score
* recommendations
* timestamps

---

## Usage Guide

### Adding SEO Pages

1. Open SEO Pages section
2. Click Add New Page
3. Enter URL and Meta Information
4. Save

### Running SEO Audits

1. Open Page Details
2. Click Run SEO Audit
3. Review Score and Recommendations
4. Check Audit History

### Generating Sitemap

Generate:

```
http://127.0.0.1:8000/sitemap-generate
```

View Sitemap:

```
http://127.0.0.1:8000/sitemap.xml
```

### Managing Robots.txt

Generate:

```
http://127.0.0.1:8000/robots-generate
```

View:

```
http://127.0.0.1:8000/robots.txt
```

---

## API Endpoints

### Web Routes

```
GET     /                     Welcome Page
GET     /dashboard            Dashboard
GET     /seo-pages            List Pages
POST    /seo-pages            Create Page
GET     /seo-pages/{id}       Show Page
PUT     /seo-pages/{id}       Update Page
DELETE  /seo-pages/{id}       Delete Page
POST    /seo-pages/{id}/audit Run Audit
GET     /seo-pages/{id}/history Audit History
GET     /sitemap-generate     Generate Sitemap
GET     /sitemap.xml          View Sitemap
GET     /robots-generate      Generate Robots
GET     /robots.txt           View Robots
```

---

## SEO Analysis Components

### Meta Tag Analysis

* Title Length Validation
* Meta Description Validation
* H1 Tag Presence
* Open Graph Verification
* Keyword Analysis

### Content Analysis

* Word Count
* Image Count
* Internal Links
* External Links

### Structure Evaluation

* Performance Scoring
* Overall SEO Score
* Issue Identification
* Recommendations
* Historical Comparison

---

## Customization

### Add New Audit Types

Extend `SeoAuditController` and register new methods.

### Modify Scoring Algorithm

Update logic in `SeoAnalyzerService`.

### Add New Page Fields

* Update Migration
* Update Model `$fillable`
* Update Controller Validation
* Update Views

---
## Screenshort
<img width="1628" height="951" alt="image" src="https://github.com/user-attachments/assets/e4adc7f8-d54d-4dab-a6ca-e7576612c88d" />
<img width="1725" height="570" alt="image" src="https://github.com/user-attachments/assets/97ab9eb6-0e73-4c57-9bd4-961e3e75f848" />
<img width="1636" height="959" alt="image" src="https://github.com/user-attachments/assets/031d2a17-ecc5-4a24-8503-bfc48c868292" />
<img width="1741" height="919" alt="image" src="https://github.com/user-attachments/assets/fb7c32fb-0d61-42af-b278-af8d0c86dcd7" />
```
```
## Best Practices

### SEO Guidelines

* Title Under 60 Characters
* Meta Description 120–160 Characters
* Single H1 Tag
* Open Graph Tags
* Canonical URLs
* JSON‑LD Support

### Code Standards

* PSR‑12 Coding
* Service Classes
* Repository Pattern
* Blade Layouts
* Form Request Validation

---

## Troubleshooting

### Database Connection

Ensure MySQL is running and credentials are correct.

### Sitemap Generation

Check write permission in public folder.

### Audit Issues

Verify page URL returns valid HTML.

### Debugging

```
storage/logs/laravel.log
APP_DEBUG=true
php artisan route:list
```

---

## Extending the Project

### Planned Features

* Google Search Console Integration
* Keyword Rank Tracking
* Competitor Analysis
* Automated Reports
* Multi‑User Roles

### Integrations

* Google Analytics API
* PageSpeed Insights
* Social Media APIs
* CMS Platforms
* E‑commerce Systems

---

## Contributing

1. Fork Repository
2. Create Feature Branch
3. Commit Changes
4. Push Branch
5. Create Pull Request

---

## License

MIT License

---

## Support

Use GitHub Issues for bug reports and feature requests.

