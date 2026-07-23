<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddIndexes extends AbstractMigration
{
    public function change(): void
    {
        $sql = <<<'SQL'
CREATE INDEX IF NOT EXISTS `idx_centers_rid` ON `centers` (`rid`);

CREATE INDEX IF NOT EXISTS `idx_rfs_uid_status_dt` ON `tolly_ready_for_shoot` (`uid`, `status`, `dt`);
CREATE INDEX IF NOT EXISTS `idx_rfs_uid_rid` ON `tolly_ready_for_shoot` (`uid`, `rid`);

CREATE INDEX IF NOT EXISTS `idx_release_uid_rid` ON `tolly_release` (`uid`, `rid`);

CREATE INDEX IF NOT EXISTS `idx_s1_uid_sid` ON `tolly_s1` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s2_uid_sid` ON `tolly_s2` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s3_uid_sid` ON `tolly_s3` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s4_uid_sid` ON `tolly_s4` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s5_uid_sid` ON `tolly_s5` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s6_uid_sid` ON `tolly_s6` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s7_uid_sid` ON `tolly_s7` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s8_uid_sid` ON `tolly_s8` (`uid`, `sid`);
CREATE INDEX IF NOT EXISTS `idx_s9_uid_sid` ON `tolly_s9` (`uid`, `sid`);
SQL;

        $this->execute($sql);
    }
}
