<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Good to see you want to learn more about magic <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If you are sure you want to learn the fireball spell type <?= $this->render('/blocks/command', ['command' => 'learn']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Pick wisely though, you can only learn one of the three traits and you cannot change them once chosen.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If you want to learn a different trait instead visit <?= $this->render('/blocks/npc', ['npc' => $this->animalTamer]); ?> or <?= $this->render('/blocks/npc', ['npc' => $this->littleKid]); ?>.</pre>
