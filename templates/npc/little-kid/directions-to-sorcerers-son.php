<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Hey mister. Psssssst...</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Are you looking for <?= $this->render('/blocks/npc', ['npc' => $this->sorcerersSon]); ?>?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Just follow the path <?= $this->render('/blocks/direction', ['direction' => 'north']); ?> from here and then go to the <?= $this->render('/blocks/direction', ['direction' => 'east']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Don't forget to use the <?= $this->render('/blocks/command', ['command' => 'look']); ?> command to get an idea about your surroundings!</pre>
