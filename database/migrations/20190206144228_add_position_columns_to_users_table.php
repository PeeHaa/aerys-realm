<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class AddPositionColumnsToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('map', 'string', ['limit' => 255, 'null' => true, 'default' => 'starters-realm'])
            ->addColumn('position_x', 'integer', ['signed' => false, 'null' => true, 'default' => 3, 'limit' => 1024])
            ->addColumn('position_y', 'integer', ['signed' => false, 'null' => true, 'default' => 1, 'limit' => 1024])
            ->addIndex(['position_x', 'position_y'])
            ->update()
        ;
    }
}
