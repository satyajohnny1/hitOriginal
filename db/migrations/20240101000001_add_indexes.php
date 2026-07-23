<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddIndexes extends AbstractMigration
{
    public function up(): void
    {
        $sql = file_get_contents(__DIR__ . '/add_indexes.sql');
        $this->execute($sql);
    }
}
