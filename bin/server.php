#!/usr/bin/env php
<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Bin;

use Auryn\Injector;
use PeeHaa\AerysRealmII\Server;

require_once __DIR__ . '/../bootstrap.php';

/** @var Injector $auryn */
$auryn->execute([(new Server($auryn, $argv)), 'start']);
