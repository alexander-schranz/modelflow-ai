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

namespace ModelflowAi\Core\Request\Criteria;

use ModelflowAi\Core\DecisionTree\DecisionEnum;

readonly class AIRequestCriteriaCollection
{
    /**
     * @param AiCriteriaInterface[] $criteria
     */
    public function __construct(
        public array $criteria = [],
    ) {
    }

    /**
     * @param AiCriteriaInterface[] $toMatch
     */
    public function matches(array $toMatch): bool
    {
        $sameType = [];
        foreach ($this->criteria as $criteria) {
            foreach ($toMatch as $toMatchCriteria) {
                $decision = $criteria->matches($toMatchCriteria);
                if (DecisionEnum::NO_MATCH === $decision) {
                    return false;
                }
                if (DecisionEnum::SAME_TYPE === $decision) {
                    $sameType[$criteria::class] ??= 0;
                    --$sameType[$criteria::class];
                }
                if (DecisionEnum::MATCH === $decision) {
                    $sameType[$criteria::class] ??= 0;
                    ++$sameType[$criteria::class];
                }
            }
        }

        foreach ($sameType as $match) {
            if (0 > $match) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param FeatureCriteria[] $features
     */
    public function withFeatures(array $features): self
    {
        return new self(\array_merge($this->criteria, $features));
    }
}
