<?php

namespace App\Models;

use App\Models\DB;
use App\Models\Entity;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class RestaurantManager
{
    public static function getAllRestaurantsOfUser()
    {
        $restaurantsGroup = [];
        $restaurants = DB\Group::with(['groupUsers' => function ($query) {
            $query->where('status', Helper::STATUS_ACTIVE);
        }, 'restaurants' => function ($q) {
            $q->where('status', Helper::STATUS_ACTIVE);
        }])
        ->where('status', Helper::STATUS_ACTIVE)
        ->whereHas('groupUsers', function ($query) {
            $query->where('user_id', Auth::id());
            $query->where('status', Helper::STATUS_ACTIVE);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        foreach ($restaurants as $restaurant) {
            $restaurantsGroup[] = GroupManager::map($restaurant);
        }

        return $restaurantsGroup;
    }

    public static function map(DB\Restaurant $restaurantData)
    {
        $restaurant = new Entity\Restaurant();
        $restaurant->setId($restaurantData->id);
        $restaurant->setName($restaurantData->name);
        $restaurant->setGroupId($restaurantData->group_id);
        $restaurant->setStatus($restaurantData->status);
        $restaurant->setAveragePrice($restaurantData->average_price);

        return $restaurant;
    }

    public static function delete(Entity\Restaurant $restaurant)
    {
        try {
            $restaurant->setStatus(Helper::STATUS_DELETED);
        } catch (\Exception $e) {
            return $e;
        }

        if ($restaurant->save()) {
            return true;
        }
        return false;
    }

    public static function save(Entity\Restaurant $restaurant)
    {        
        if (Helper::isNull($restaurant->getId())) {
            $newRestaurant = new DB\Restaurant();
            $restaurant->setId(Helper::generateId());
            $restaurant->setStatus(Helper::STATUS_ACTIVE);
            $restaurant->setAveragePrice(0.00);
        } else {
            $newRestaurant = DB\Restaurant::find($restaurant->getId());
        }

        // @TODO burdaki oldValue ve newRestaurant log olarak tutualacak
        $oldValue = self::map($newRestaurant);

        if ($newRestaurant instanceof DB\Restaurant) {
            $newRestaurant->id = $restaurant->getId();
            $newRestaurant->name = $restaurant->getName();
            $newRestaurant->group_id = $restaurant->getGroupId();
            $newRestaurant->status = $restaurant->getStatus();
            $newRestaurant->average_price = $restaurant->getAveragePrice();
            $newRestaurant->save();

            return $restaurant->getId();
        }
    }

    public static function update(Entity\Restaurant $restaurant)
    {
        if ($restaurant->getId()) {
            $model = DB\Restaurant::where('id', $restaurant->getId())
                ->update(['average_price' => $restaurant->getAveragePrice()]);
        }
        return $model;
    }

    public static function remove($id)
    {
        if(!empty($id)) {
            $model = DB\Restaurant::where('id', $id)
                ->update(['status' => Helper::STATUS_DELETED]);
        }

        return $model;
    }
}


    // public static function getAllGroupsByGivingPrice()
    // {
    //     $restaurantUsers = DB\RestaurantUser::where('user_id', Auth::id())
    //        ->with(['restaurant' => function ($query) {
    //             $query->where('restaurant.status', Helper::STATUS_ACTIVE)
    //                 ->with(['group'=> function ($q) {
    //                     $q->where('group.status', Helper::STATUS_ACTIVE);
    //                 }]);
    //             }])
    //         ->where('status', Helper::STATUS_ACTIVE)
    //         ->get();

    //     foreach ($restaurantUsers as $restaurantUser) {
    //         $restaurant[] = self::multipleUserDataMapper($restaurantUser);
    //     }

    //     return $restaurant;
    // }

    // public static function multipleUserDataMapper(DB\RestaurantUser $restaurantUserData)
    // {
    //     $restaurantUser = new Entity\RestaurantUser();
    //     $restaurantUser->setId($restaurantUserData->id);
    //     $restaurantUser->setRestaurantId($restaurantUserData->restaurantId);
    //     $restaurantUser->setUserId($restaurantUserData->userId);
    //     $restaurantUser->setBudget($restaurantUserData->budget);
    //     $restaurantUser->setStatus($restaurantUserData->status);

    //     if ($restaurantUserData->relationLoaded('restaurant') && !empty($restaurantUserData->restaurant)) {
    //         $restaurantUser->setRestaurant(self::map($restaurantUserData->restaurant));
    //     }

    //     if ($restaurantUserData->restaurant->relationLoaded('group') && !empty($restaurantUserData->restaurant->group)) {
    //         $restaurantUser->setRestaurantGroup(GroupManager::map($restaurantUserData->restaurant->group));
    //     }

    //     return $restaurantUser;
    // }