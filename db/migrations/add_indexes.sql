-- Performance index migration for the hot movie-flow tables.
-- Apply this to the existing production database.

ALTER TABLE `centers`
  ADD INDEX `idx_centers_rid` (`rid`);

ALTER TABLE `tolly_ready_for_shoot`
  ADD INDEX `idx_rfs_uid_status_dt` (`uid`, `status`, `dt`),
  ADD INDEX `idx_rfs_uid_rid` (`uid`, `rid`);

ALTER TABLE `tolly_release`
  ADD INDEX `idx_release_uid_rid` (`uid`, `rid`);

ALTER TABLE `tolly_s1`
  ADD INDEX `idx_s1_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s2`
  ADD INDEX `idx_s2_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s3`
  ADD INDEX `idx_s3_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s4`
  ADD INDEX `idx_s4_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s5`
  ADD INDEX `idx_s5_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s6`
  ADD INDEX `idx_s6_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s7`
  ADD INDEX `idx_s7_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s8`
  ADD INDEX `idx_s8_uid_sid` (`uid`, `sid`);

ALTER TABLE `tolly_s9`
  ADD INDEX `idx_s9_uid_sid` (`uid`, `sid`);
