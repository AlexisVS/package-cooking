<?php


/*
    This file is part of the Discope property management software.
    Author: Yesbabylon SRL, 2020-2022
    License: GNU AGPL 3 license <http://www.gnu.org/licenses/>
*/

use equal\orm\Domain;
use equal\orm\ObjectManager;
use equal\php\Context;

list($params, $providers) = eQual::announce([
    'description' => 'Get a list of ingredients related to a meal.',
    'extends' => 'core_model_collect',
    'params' => [
        'entity' => [
            'description' => 'name',
            'type' => 'string',
            'default' => 'cooking\Ingredient'
        ],
    ],
    'response' => [
        'content-type' => 'application/json',
        'charset' => 'utf-8',
        'accept-origin' => '*'
    ],
    'providers' => ['context', 'orm']
]);

/**
 * @var Context $context
 * @var ObjectManager $orm
 */
list($context, $orm) = [$providers['context'], $providers['orm']];

//   Add conditions to the domain to consider advanced parameters
$domain = $params['domain'];

if (isset($params['direction']) && strlen($params['direction']) > 0) {
    $domain = Domain::conditionAdd($domain, ['direction', 'like', '%' . $params['direction'] . '%']);
}

$params['domain'] = $domain;
$result = eQual::run('get', 'model_collect', $params, true); //always true, it return array.

$context->httpResponse()
    ->body($result)
    ->send();
