<?php declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateItemsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('items', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addColumn('class_name', 'string', ['limit' => 255])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE'])
            ->create()
        ;
    }
}
