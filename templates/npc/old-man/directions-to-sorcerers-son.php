<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Hey <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: It seems you are a bit lost here.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Are you looking for <?= $this->render('/blocks/npc', ['npc' => $this->sorcerersSon]); ?>?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Just follow the path <?= $this->render('/blocks/direction', ['direction' => 'east']); ?> from here and then go all the way to the <?= $this->render('/blocks/direction', ['direction' => 'north']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: From there it's just over to the <?= $this->render('/blocks/direction', ['direction' => 'west']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Don't forget to use the <?= $this->render('/blocks/command', ['command' => 'look']); ?> command to get an idea about your surroundings!</pre>
