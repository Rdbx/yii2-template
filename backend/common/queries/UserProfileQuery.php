<?php

namespace common\queries;

/**
 * This is the ActiveQuery class for [[\common\database\table\UserProfile]].
 *
 * @see \common\database\table\UserProfile
 */
class UserProfileQuery extends \common\AbstractActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\database\table\UserProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\database\table\UserProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
