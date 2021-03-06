<?php

namespace App\Models\Entity;

use App\Models\RestaurantManager;

class Restaurant
{
    private $id;
    private $name;
    private $groupId;
    private $group;
    private $status;
    private $averagePrice;
    private $regenerateCount;
    private $restaurantUsers;
    private $distance;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAveragePrice()
    {
        return $this->averagePrice;
    }

    /**
     * @param mixed $averagePrice
     */
    public function setAveragePrice($averagePrice)
    {
        $this->averagePrice = $averagePrice;
    }

    public function getRegenerateCount()
    {
        return $this->regenerateCount;
    }

    public function setRegenerateCount($regenerateCount)
    {
        $this->regenerateCount = $regenerateCount;
    }

    public function getRestaurantUsers()
    {
        return $this->restaurantUsers;
    }

    public function setRestaurantUsers($restaurantUsers)
    {
        $this->restaurantUsers = $restaurantUsers;
    }

    public function save($restaurant)
    {
        return RestaurantManager::save($restaurant);
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }
}
