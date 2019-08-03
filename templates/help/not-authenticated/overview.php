<?php declare(strict_types=1); ?>
<pre>List of available commands: <?= $this->render('/blocks/command', ['command' => 'help']); ?>, <?= $this->render('/blocks/command', ['command' => 'login']); ?>, <?= $this->render('/blocks/command', ['command' => 'register']); ?>.</pre>
<pre>Type <?= $this->render('/blocks/command', ['command' => 'help command']); ?> to get more information about a specific command.</pre>
