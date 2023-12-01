<?php

namespace cooking;

use equal\orm\Model;

class Ingredient extends Model
{
    public static function getColumns(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'description' => 'Name of the Ingredient.',
                'required' => true,
                'unique' => true
            ],

            'description' => [
                'type' => 'text',
                'description' => 'Description of the Ingredient.',
                'required' => false,
            ],

            'native_land' => [
                'type' => 'string',
                'description' => 'Native land of the Ingredient.',
                'required' => false,
            ],

            'meals_ids' => [
                'type' => 'many2many',
                'foreign_object' => 'cooking\Meal',
                'foreign_field' => 'meals_ids',
                'rel_table' => 'cooking_rel_meal_ingredient',
                'rel_foreign_key' => 'meal_id',
                'rel_local_key' => 'ingredient_id',
            ]
        ];
    }
}
