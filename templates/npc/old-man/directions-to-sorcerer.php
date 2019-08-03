<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Hey <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Are you looking for <?= $this->render('/blocks/npc', ['npc' => $this->sorcerer]); ?>?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Go <?= $this->render('/blocks/direction', ['direction' => 'south']); ?> from here and then go all the way to the <?= $this->render('/blocks/direction', ['direction' => 'west']); ?>.</pre>
