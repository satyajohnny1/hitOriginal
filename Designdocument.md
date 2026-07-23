# Design Document

## Project Overview

This project is a legacy PHP web application for simulating and managing a movie production lifecycle. It appears to be branded around "HitandFut" and supports a workflow that moves a movie from crew selection to shooting, release, theatrical run, and final results.

The application is built as a server-rendered PHP site backed by MySQL, with JavaScript and Ajax used for interactive actions such as login, workflow transitions, and dashboard updates. The codebase also includes poster generation utilities, theater/center data, and multiple supporting assets for admin and public pages.

## Primary Goals

- Let users create and manage movies using a roster of actors, directors, writers, music, editors, and cinematography talent.
- Track each movie through staged status transitions.
- Compute and display business-style metrics such as budget, collection, profit, rating, and center counts.
- Generate and maintain visual posters for movies and cast members.
- Support operational tasks such as backup, email, and deployment.

## High-Level Architecture

### Presentation Layer

- PHP page templates render HTML directly.
- Shared layout pieces such as the navbar, side menu, and CSS are included from reusable PHP files.
- Admin UI assets are stored under directories such as `assets/`, `adminassets/`, `own/`, and `share/`.
- The dashboard uses chart containers and tables to summarize current movie status.

### Application Layer

- Business logic is mostly embedded in individual PHP files rather than centralized in controllers or services.
- Ajax endpoints handle asynchronous operations such as login, status changes, rating updates, and dashboard interactions.
- Workflow actions are split across focused entry-point files such as `makemovie.php`, `readyforshoot.php`, `shooting.php`, `readyforrelease.php`, `release.php`, and `running.php`.

### Data Layer

- MySQL is the primary persistent store.
- Connection details are centralized in `db.php`.
- Schema definitions are kept in `X_DB/createTables.sql` and related SQL dump files.
- The application uses tables for talent catalogs, movie lifecycle records, theater lists, center counts, news, and stage-specific state.

### Supporting Utilities

- Poster generation code lives under `poster/` and `hindi/`.
- Google API client code and other third-party utilities are stored under `tools/`.
- Email-related functionality uses SendGrid through Composer dependencies.
- Backup and maintenance scripts are present for manual or cron-driven operation.

## Core Domain Model

### Talent Catalogs

The application maintains separate entities for:

- Actors
- Actresses
- Directors
- Writers
- Music directors
- Editors
- Cinematographers

Each catalog stores identity, rating, cost/rate, grade, status, and picture metadata.

### Movie Lifecycle

The central movie record is tracked through a staged production pipeline:

1. Movie creation and crew selection
2. Ready for shoot
3. Shooting
4. Shoot completion
5. Ready for release
6. Release
7. Running in theaters
8. Forced exit or final closure

The workflow is represented in tables such as `tolly_ready_for_shoot`, `tolly_release`, and related status fields.

### Theater and Center Management

- Theater locations and capacities are stored in `thearterslist`.
- Center distribution and collection thresholds are tracked in `centers` and release-related fields.
- The system appears to use capacity and day-based collection thresholds to model performance over time.

### News and Dashboard Content

- `tolly_news` stores in-app updates or announcements.
- The dashboard surfaces active items in each lifecycle stage and recent news entries.

## Major User Flows

### Authentication

- Users sign in through `login.php`.
- Login is handled asynchronously via `loginAjax.php`.
- Session state is used to gate access to user pages such as `userdashboard.php`.

### Movie Creation

- Users build a movie by selecting the required crew and production components.
- The selected items are persisted into the shoot-ready record.

### Production Progression

- The movie moves through shoot and release stages via dedicated pages and Ajax actions.
- Status changes are reflected in the dashboard and in the associated record fields.

### Running and Revenue Tracking

- Once released, a movie enters the running phase.
- Day counts, theater counts, and collection milestones are updated as the movie progresses.
- Collection and profit metrics are stored alongside the record.

### Poster Generation

- Poster scripts create movie or actor posters using bundled fonts and image assets.
- The repo includes generated outputs and reusable background/actor artwork, suggesting poster creation is a first-class feature rather than a side utility.

## Key Files and Roles

- `index.php`: main login entry point.
- `userdashboard.php`: authenticated dashboard showing current movie status and news.
- `db.php`: database connection bootstrap.
- `X_DB/createTables.sql`: canonical table definitions for the app domain.
- `poster/`: poster generation scripts, fonts, and output assets.
- `tools/`: utility scripts including backup and external service helpers.
- `composer.json`: PHP dependency declaration, currently including SendGrid.

## Data and State Conventions

- Most tables use simple numeric IDs and denormalized text fields for names and status snapshots.
- Movie state appears to be encoded through string status fields such as `ready`, `shootout`, and `running`.
- Several tables store both relational IDs and denormalized display names, which simplifies rendering but increases the chance of stale data.
- Numeric performance fields are stored directly on movie records instead of being computed on demand.

## Integration Points

### Email

The project includes SendGrid support through Composer, which likely handles notifications and backup delivery.

### Google Services

The `tools/google-api-php-client/` directory suggests historical or optional integration with Google APIs.

### Deployment and Backup

- The README documents cron-based backup endpoints.
- Deployment appears to rely on external FTP/deployment automation.
- Backups may be exported as SQL and stored externally.

## Non-Functional Characteristics

### Strengths

- Straightforward deployment model for shared hosting or VPS environments.
- Clear separation of page-level workflows.
- Rich asset library for posters and UI presentation.

### Risks

- Logic is distributed across many PHP files, which makes behavior harder to reason about.
- The database connection details are hard-coded in `db.php`.
- Several tables use denormalized fields and broad `longtext` storage.
- The codebase appears to rely on legacy libraries and old-style PHP patterns.

## Suggested Direction for Future Work

- Consolidate repeated workflow logic into shared service functions.
- Move configuration out of source-controlled PHP files.
- Introduce a central model/service layer for movie lifecycle transitions.
- Add tests around stage transitions and revenue calculations.
- Document the poster pipeline and regenerate process in more detail.

## Notes

This document is intentionally high level and reflects the current structure of the repository, not an idealized redesign. Some interpretations, especially around lifecycle semantics, are inferred from file names, schema names, and existing pages.
