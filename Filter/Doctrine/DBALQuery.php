<?php

namespace Lexik\Bundle\FormFilterBundle\Filter\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Condition\Condition;
use Lexik\Bundle\FormFilterBundle\Filter\Doctrine\Expression\DBALExpressionBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

/**
 * @author Jeremy Barthe <j.barthe@lexik.fr>
 */
class DBALQuery implements QueryInterface
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var DBALExpressionBuilder
     */
    private $expressionBuilder;

    /**
     * Constructor.
     *
     * @param QueryBuilder $queryBuilder
     * @param bool         $forceCaseInsensitivity
     */
    public function __construct(QueryBuilder $queryBuilder, $forceCaseInsensitivity = false)
    {
        $this->queryBuilder = $queryBuilder;
        $this->expressionBuilder = new DBALExpressionBuilder(
            $this->queryBuilder->expr(),
            $forceCaseInsensitivity
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getEventPartName()
    {
        return 'dbal';
    }

    /**
     * {@inheritDoc}
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function createCondition($expression, array $parameters = array())
    {
        return new Condition($expression, $parameters);
    }

    /**
     * Get QueryBuilder expr.
     *
     * @return \Doctrine\DBAL\Query\Expression\ExpressionBuilder
     */
    public function getExpr()
    {
        return $this->queryBuilder->expr();
    }

    /**
     * {@inheritDoc}
     */
    public function getRootAlias()
    {
        $from = $this->queryBuilder->getQueryPart('from');

        return $from[0]['alias'];
    }

    /**
     * Get expr class.
     *
     * @return \Lexik\Bundle\FormFilterBundle\Filter\Doctrine\Expression\ExpressionBuilder
     */
    public function getExpressionBuilder()
    {
        return $this->expressionBuilder;
    }
}
