<?php declare(strict_types=1); ?>
<pre>Type <?= $this->render('/blocks/command', ['command' => 'login']); ?> and you will be prompted for your username and password. If you do not have an account yet type <?= $this->render('/blocks/command', ['command' => 'register']); ?>.</pre>
