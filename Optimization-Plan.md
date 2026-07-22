# Optimization Plan

## Scope

This plan focuses on performance improvements that do not change the core game logic:

- faster database reads
- fewer queries per page
- narrower result sets
- easier-to-maintain query paths
- use of modern PHP patterns where they reduce overhead or duplication

The current codebase is a legacy PHP/MySQL application with repeated query patterns and several pages that load the same movie data in multiple passes. The biggest wins will come from database indexing and query shaping before any deeper refactor.

## Performance Goals

- Reduce query count on dashboard and movie pages
- Improve lookup speed for the movie lifecycle tables
- Make hot-path Ajax calls faster and more predictable
- Avoid changing the behavior of scoring, release, and collection logic

## Phase 1: Add The Right Database Indexes

This is the first and highest-value optimization.

### Why This Matters

Most of the application reads and updates rows using a small set of lookup patterns:

- `uid + status`
- `uid + rid`
- `rid`
- direct movie lifecycle filters such as `status = 'out'`

Without supporting indexes, MySQL has to scan more rows than needed. That is especially expensive in:

- `userdashboard.php`
- `release.php`
- `running.php`
- `mydata.php`
- `shooting.php`
- `ratingAjax.php`
- `addcenters.php`

### Recommended Indexes

#### `tolly_ready_for_shoot`

This table is the main movie lifecycle table and should be indexed for the app's most common access patterns.

Recommended indexes:

```sql
CREATE INDEX idx_rfs_uid_status ON tolly_ready_for_shoot (uid, status);
CREATE INDEX idx_rfs_uid_rid ON tolly_ready_for_shoot (uid, rid);
CREATE INDEX idx_rfs_rid ON tolly_ready_for_shoot (rid);
CREATE INDEX idx_rfs_uid_dt ON tolly_ready_for_shoot (uid, dt);
```

Notes:

- `uid, status` helps dashboard lists and movie queues.
- `uid, rid` helps single-movie lookups in `shooting.php`, `release.php`, `running.php`, and `ratingAjax.php`.
- `uid, dt` helps ordered “last 5 movies” and recent activity queries.

#### `tolly_release`

This table is read frequently by `release.php`, `running.php`, and `addcenters.php`.

Recommended indexes:

```sql
CREATE INDEX idx_release_uid_rid ON tolly_release (uid, rid);
CREATE INDEX idx_release_rid ON tolly_release (rid);
```

Notes:

- `uid, rid` matches the primary release and running lookup path.
- `rid` helps direct fetches and cleanup operations.

#### `centers`

This table is keyed by `rid` but currently has no visible primary key in the schema dump.

Recommended index:

```sql
CREATE INDEX idx_centers_rid ON centers (rid);
```

If `rid` is unique per movie, consider a primary key or unique key later. For now, an index is enough to speed read/write lookups.

#### Summary Tables and Catalog Tables

The actor, actress, director, writer, music, cine, and editor tables already have primary keys. That is usually enough for direct ID lookups.

If later profiling shows slow range scans on status or grade fields, add indexes only after confirming the access pattern.

### First Delivery for Phase 1

Add the indexes above first, then re-test:

- dashboard load time
- release page load time
- single movie page load time
- Ajax stage update time

### Expected Impact

- Faster row lookup for core movie lifecycle pages
- Lower MySQL CPU cost
- Better responsiveness when the number of movies grows

## Phase 2: Narrow Queries And Remove Repeated Fetches

This is the next highest-value optimization.

### Why This Matters

The codebase relies heavily on `SELECT *` and repeated queries for the same row. That creates unnecessary overhead in:

- network transfer
- PHP memory use
- MySQL row decoding
- repeated round-trips to the database

### Pages To Optimize First

#### `release.php`

Current pattern:

- fetch one movie row with `SELECT *`
- fetch one release row with `SELECT *`

Plan:

- fetch only the columns actually used on the page
- keep the two queries if needed, but narrow the select list

Needed fields:

- from `tolly_ready_for_shoot`: `rid`, `title`, `sofar`, `dname`, `aname`, `acname`
- from `tolly_release`: `rel_cen`

Example shape:

```sql
SELECT rid, title, sofar, dname, aname, acname
FROM tolly_ready_for_shoot
WHERE uid = ? AND rid = ?;
```

```sql
SELECT rel_cen
FROM tolly_release
WHERE uid = ? AND rid = ?;
```

#### `running.php`

Current pattern:

- load `tolly_release`
- load `tolly_ready_for_shoot`
- populate many fields with `SELECT *`

Plan:

- fetch only required columns for display and poster logic
- avoid bringing the full row into PHP when only a subset is rendered

Needed fields will be mostly:

- identifiers
- titles
- names
- dates
- rating and collections
- center counts
- poster flag

#### `mydata.php`

Current pattern:

- fetch out movies
- for each row, fetch matching release data

This is a classic N+1 pattern.

Plan:

- replace the per-row release lookup with one joined query
- fetch both movie and release columns in a single pass

Example shape:

```sql
SELECT
  s.rid,
  s.title,
  s.dname,
  s.aname,
  s.result,
  s.collection,
  s.sofar,
  r.50d_cen,
  r.100d_cen
FROM tolly_ready_for_shoot s
LEFT JOIN tolly_release r
  ON r.uid = s.uid AND r.rid = s.rid
WHERE s.uid = ? AND s.status = 'out'
ORDER BY s.dt DESC;
```

That removes one query per movie row.

#### `userdashboard.php`

Current pattern:

- three separate status lists
- news fetch
- pie chart data
- success rate query
- last 5 query

Plan:

- keep the page structure but reduce duplicate data fetches
- query the base movie stats once where possible
- use a single `SELECT` for recent movie rows instead of repeated `SELECT *`

Potential consolidation:

- one query for movies in `ready`
- one query for movies in `shootout`
- one query for movies in `running`
- one query for news
- one query for chart aggregates

Later, a stronger optimization would be to build a single dashboard summary query or a small stats endpoint.

### Files To Update In Phase 2

- `release.php`
- `running.php`
- `mydata.php`
- `userdashboard.php`
- `shooting.php`
- `ratingAjax.php`
- `addcenters.php`

### Expected Impact

- Lower memory usage
- Less DB traffic
- Faster page rendering
- Cleaner code paths for later refactor

## Phase 3: Follow-up Improvements

These are useful but should come after the first two phases.

### Transactions For Multi-Write Flows

Use transactions around:

- `ratingAjax.php`
- `addcenters.php`
- release completion logic

This keeps the state consistent and can reduce write overhead.

### Prepared Statements

Convert write paths and hot reads to prepared statements.

This helps with:

- safety
- query plan reuse
- easier maintenance

### Shared DB Helper

Add a small DB utility layer for:

- `fetchOne`
- `fetchAll`
- `execute`
- `beginTransaction`
- `commit`
- `rollback`

### Modern PHP Cleanup

Since the deployment target is PHP 8.3, use:

- `strict_types` where safe
- typed helper functions
- `match` for status mapping
- small immutable helper objects if needed

This should be done only after the query hot paths are improved.

## Recommended Order Of Work

1. Add indexes
2. Narrow the top queries
3. Remove N+1 queries from dashboards and movie pages
4. Wrap multi-write flows in transactions
5. Add prepared statements and a shared DB helper
6. Apply small PHP 8.3 cleanup where it reduces duplication

## Validation Checklist

After each phase, verify:

- dashboard page load time
- single movie page load time
- release page load time
- Ajax rating response time
- no behavior changes in the movie lifecycle

## Notes

This plan intentionally avoids changing the game logic. The goal is to make the current system faster, easier to maintain, and safer to extend.
