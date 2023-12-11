<?php


namespace cooking;

use equal\orm\Model;

class MealCategory extends Model
{

    public static function getColumns(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'required' => true,
                'unique' => true
            ],

            'description' => [
                'type' => 'text',
                'required' => false,
            ],
            'meals_ids' => [
                'type' => 'many2many',
                'foreign_object' => 'cooking\Meal',
                'foreign_field' => 'mealcategories_ids',
                'rel_table' => 'cooking_rel_meal_mealcategory',
                'rel_foreign_key' => 'meal_id',
                'rel_local_key' => 'mealcategory_id',
                'description' => 'Meals the meal category belongs to.'
            ],
        ];
    }
}
