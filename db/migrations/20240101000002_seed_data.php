<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SeedData extends AbstractMigration
{
    public function up(): void
    {
        $sql = file_get_contents(__DIR__ . '/Data.sql');
        $this->execute($sql);
    }
}
