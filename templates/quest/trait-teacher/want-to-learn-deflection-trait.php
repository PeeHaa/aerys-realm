<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: You want to learn the deflection trait? That's cool <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Heads-up though, you can only learn one of the three traits and you cannot change them once chosen.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If you are sure you want to learn the deflection trait type <?= $this->render('/blocks/command', ['command' => 'learn']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: No hard feelings if you want to learn a different trait instead.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Just go visit <?= $this->render('/blocks/npc', ['npc' => $this->sorcerer]); ?> or <?= $this->render('/blocks/npc', ['npc' => $this->animalTamer]); ?>.</pre>
