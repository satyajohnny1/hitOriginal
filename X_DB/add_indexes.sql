-- Performance index migration for the hot movie-flow tables.
-- Apply this to the existing production database.

ALTER TABLE `centers`
  ADD INDEX `idx_centers_rid` (`rid`);

ALTER TABLE `tolly_ready_for_shoot`
  ADD INDEX `idx_rfs_uid_status_dt` (`uid`, `status`, `dt`),
  ADD INDEX `idx_rfs_uid_rid` (`uid`, `rid`);

ALTER TABLE `tolly_release`
  ADD INDEX `idx_release_uid_rid` (`uid`, `rid`);
