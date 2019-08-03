<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class AddExperienceToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('xp', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->update()
        ;
    }
}
