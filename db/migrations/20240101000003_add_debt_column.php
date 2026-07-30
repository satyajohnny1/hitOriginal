<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDebtColumn extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("ALTER TABLE tolly_user ADD COLUMN debt double NOT NULL DEFAULT 0 AFTER bal");
    }
}
