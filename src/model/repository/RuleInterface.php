<?php

namespace zongphp\model\repository;

/**
 * 查询规则接口
 * Interface RuleInterface
 *
 * @package system\repository\contracts
 */
interface RuleInterface
{
    /**
     * 重新使用规则
     *
     * @return $this
     */
    public function resetRule();

    /**
     * 不执行任何规则
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipRule($status = true);

    /**
     * 获取所有规则
     *
     * @return mixed
     */
    public function getRule();

    /**
     * 获取指定的规则
     *
     * @param Rule $Rule
     *
     * @return $this
     */
    public function getByRule(Rule $Rule);

    /**
     * 添加规则
     *
     * @param Rule $Rule
     *
     * @return $this
     */
    public function pushRule(Rule $Rule);

    /**
     * 使用集合中的所有规则
     *
     * @return $this
     */
    public function applyRule();
}