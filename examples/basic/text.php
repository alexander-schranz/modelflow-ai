<?php

declare(strict_types=1);

/*
 * This file is part of the Modelflow AI package.
 *
 * (c) Johannes Wachter <johannes@sulu.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use ModelflowAi\Core\AIRequestHandlerInterface;
use ModelflowAi\Core\Request\Criteria\PrivacyRequirement;
use ModelflowAi\Core\Response\AITextResponse;

/** @var AIRequestHandlerInterface $handler */
$handler = require_once __DIR__ . '/bootstrap.php';

/** @var AITextResponse $response */
$response = $handler->createTextRequest('Hello World')
    ->addCriteria(PrivacyRequirement::HIGH)
    ->build()
    ->execute();

echo $response->getText();
