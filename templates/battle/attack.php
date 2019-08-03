<?php declare(strict_types=1); ?>
<pre>You start an <?= $this->render('/blocks/command', ['command' => 'attack']); ?> on <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?>!</pre>
