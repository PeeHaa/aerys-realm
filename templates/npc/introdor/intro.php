<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Hey <?= $this->render('/blocks/player', ['player' => $this->player]); ?>. Over here!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: So you think you are ready to go out there ey? Let me give you some last tips!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: The further you go out in the realm the stronger the enemies will get, but it seems like you are more than equipped to handle it.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: In case you manage to get yourself killed, don't worry. You will just spawn back on the <span class="location">proving grounds</span>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: While on the road make sure to look out for quests in places just like this!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Speaking of quests. I heard my friend <?= $this->render('/blocks/npc', ['npc' => $this->sorcerersSon]); ?> needs some help. He owns a <span class="location">house</span> to the <?= $this->render('/blocks/direction', ['direction' => 'north']); ?> <?= $this->render('/blocks/direction', ['direction' => 'east']); ?> from here.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Maybe you can pay him a visit and help him out?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Safe travels!</pre>
