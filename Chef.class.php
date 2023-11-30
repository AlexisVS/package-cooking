<?php


use equal\orm\Model;

class Chef extends Model
{

    public static function getColumns(): array
    {
        return [
            'user_id' => [
                'type' => 'many2one',
                'foreign_object' => 'core\User',
                'unique' => true,
                'required' => true
            ],
            'meal_id' => [
                'type' => 'many2one',
                'foreign_object' => 'Meal',
                'unique' => true,
            ],
        ];
    }
}
