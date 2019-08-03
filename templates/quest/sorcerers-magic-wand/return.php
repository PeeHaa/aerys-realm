<?php declare(strict_types=1); ?>
<pre>You give back <?= $this->render('/blocks/item', ['item' => $this->magicWand]); ?> to <?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: What do you say? My son took it?!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Sorry for your troubles and thank you for bringing it back to me.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Go back to him and tell him I told you to get a reward for your troubles and that it is coming out of his own allowance!</pre>
