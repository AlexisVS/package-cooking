<?php


namespace cooking;

use core\User;
use equal\orm\Collection;
use equal\orm\Model;
use equal\orm\ObjectManager;

class Chef extends Model
{
    public static function getColumns(): array
    {
        return [
            'name' => [
                'type' => 'computed',
                'result_type' => 'text',
                'function' => 'calcUserName',
                'store' => true,
            ],

            'user_id' => [
                'type' => 'many2one',
                'foreign_object' => 'core\User',
                'required' => true,
                'dependencies' => [0 => 'name'],
            ],

            'meals_ids' => [
                'type' => 'one2many',
                'foreign_object' => 'cooking\Meal',
                'foreign_field' => 'chef_id',
            ],
        ];
    }

    public static function calcUserName($self)
    {
//        $chef = $om->read(__class__, $ids, 'user_id')[$ids[0]];

//        return User::id($chef['user_id'])[0]['name'];


        $result = [];

        $self->read(['user_id']);

        foreach ($self as $id => $chef) {
            $result[$id] = User::id($chef['user_id'])->read(['login'])->first(true)['login'];
        }

        return $result;
    }

}
