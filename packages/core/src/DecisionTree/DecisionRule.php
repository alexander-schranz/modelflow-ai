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

namespace ModelflowAi\Core\DecisionTree;

use ModelflowAi\Core\Model\AIModelAdapterInterface;
use ModelflowAi\Core\Request\AIRequestInterface;
use ModelflowAi\Core\Request\Criteria\AiCriteriaInterface;

class DecisionRule implements DecisionRuleInterface
{
    /**
     * @param AiCriteriaInterface[] $criteria
     */
    public function __construct(
        private readonly AIModelAdapterInterface $adapter,
        private readonly array $criteria = [],
    ) {
    }

    public function matches(AIRequestInterface $request): bool
    {
        if (!$request->matches($this->criteria)) {
            return false;
        }

        return $this->adapter->supports($request);
    }

    public function getAdapter(): AIModelAdapterInterface
    {
        return $this->adapter;
    }
}
