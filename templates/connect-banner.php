<?php declare(strict_types=1); ?>
<pre>Welcome to Aerys' Realm II!</pre>
<pre>Use the <?= $this->render('/blocks/command', ['command' => 'login']); ?> command to sign in or the <?= $this->render('/blocks/command', ['command' => 'register']); ?> command to create an account.</pre>
<pre>Or use the <?= $this->render('/blocks/command', ['command' => 'help']); ?> command to see all available commands.</pre>
