<?php declare(strict_types=1); ?>
<pre class="info">****<?= str_repeat('*', $this->lineLength); ?>****
*   <?= str_repeat(' ', $this->lineLength); ?>   *
*   Player:    <?= $this->render('/blocks/player', ['player' => $this->player]); ?><?= str_repeat(' ', $this->lineLength - 8 - mb_strlen($this->player->getUsername())); ?>*
*   <?= str_repeat(' ', $this->lineLength); ?>   *
*   Level:     <?= $this->escape($this->level->getName()); ?> (<span class="enemyLevel"><?= $this->level->getNumeric(); ?></span>)<?= str_repeat(' ', $this->lineLength - 11 - (mb_strlen($this->level->getName()) + mb_strlen((string) $this->level->getNumeric()))); ?>*
*   Xp:        <?= $this->player->getExperiencePoints(); ?>/<?= $this->nextLevel->getExperiencePoints(); ?><?= str_repeat(' ', $this->lineLength - 9 - (mb_strlen((string) $this->player->getExperiencePoints()) + mb_strlen((string) $this->nextLevel->getExperiencePoints()))); ?>*
*   Hitpoints: <?= $this->player->getHitPoints(); ?>/<?= $this->level->getHitPoints(); ?><?= str_repeat(' ', $this->lineLength - 9 - (mb_strlen((string) $this->player->getHitPoints()) + mb_strlen((string) $this->level->getHitPoints()))); ?>*
*   <?= str_repeat(' ', $this->lineLength); ?>   *
*   <?= $this->escape($this->level->getDescription()); ?>   *
*   <?= str_repeat(' ', $this->lineLength); ?>   *
****<?= str_repeat('*', $this->lineLength); ?>****</pre>
