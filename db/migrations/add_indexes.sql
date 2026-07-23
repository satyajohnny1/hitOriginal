-- Performance index migration for the hot movie-flow tables.
-- Safe to run standalone or after createTables.sql: createTables.sql now defines
-- these same indexes inline, so IF NOT EXISTS guards prevent "Duplicate key name"
-- errors while still retrofitting an older database that predates them.

ALTER TABLE `centers`
  ADD INDEX IF NOT EXISTS `idx_centers_rid` (`rid`);

ALTER TABLE `tolly_ready_for_shoot`
  ADD INDEX IF NOT EXISTS `idx_rfs_uid_status_dt` (`uid`, `status`, `dt`),
  ADD INDEX IF NOT EXISTS `idx_rfs_uid_rid` (`uid`, `rid`);

ALTER TABLE `tolly_release`
  ADD INDEX IF NOT EXISTS `idx_release_uid_rid` (`uid`, `rid`);

ALTER TABLE `tolly_s1`
  ADD INDEX IF NOT EXISTS `idx_s1_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s2`
  ADD INDEX IF NOT EXISTS `idx_s2_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s3`
  ADD INDEX IF NOT EXISTS `idx_s3_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s4`
  ADD INDEX IF NOT EXISTS `idx_s4_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s5`
  ADD INDEX IF NOT EXISTS `idx_s5_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s6`
  ADD INDEX IF NOT EXISTS `idx_s6_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s7`
  ADD INDEX IF NOT EXISTS `idx_s7_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s8`
  ADD INDEX IF NOT EXISTS `idx_s8_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s9`
  ADD INDEX IF NOT EXISTS `idx_s9_uid_sid` (`uid`, `sid`);
