<?php


use equal\orm\Model;

class MealCategory extends Model
{

    public static function getColumns(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'length' => 255,
                'required' => true,
                'unique' => true
            ],

            'description' => [
                'type' => 'string',
                'length' => 255,
                'required' => false,
            ],
            'meals_ids' => [
                'type' => 'many2many',
                'foreign_object' => 'Meal',
                'foreign_field' => 'meals_ids',
                'rel_table' => 'cooking_rel_meal_mealcategory',
                'rel_foreign_key' => 'meal_id',
                'rel_local_key' => 'mealcategory_id',
            ],
        ];
    }
}
