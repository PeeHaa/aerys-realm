<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class AddAdminColumnToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('admin', 'boolean', ['null' => false, 'default' => false])
            ->update()
        ;
    }
}
