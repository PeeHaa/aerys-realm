<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateQuestsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('quests', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('user_id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('class_name', 'string', ['limit' => 255])
            ->addColumn('current_step', 'integer', ['signed' => false, 'null' => true, 'limit' => 1024])
            ->addColumn('finished', 'boolean')
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE'])
            ->create()
        ;
    }
}
