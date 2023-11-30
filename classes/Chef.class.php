<?php


namespace cooking;

use equal\orm\Model;

class Chef extends Model
{

    public static function getColumns(): array
    {
        return [
            'user_id' => [
                'type' => 'many2one',
                'foreign_object' => 'core\User',
                'required' => true
            ],
            'meals_ids' => [
                'type' => 'one2many',
                'foreign_object' => 'cooking\Meal',
                'foreign_field' => 'meal_id',
            ],
        ];
    }
}
