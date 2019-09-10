<?php
/**
 * Created by PhpStorm.
 * User: ardani
 * Date: 8/4/17
 * Time: 10:02 AM
 */

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\User;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUser'
    ];

    /*
    *   Declare type users   
    *
    */

    public function type()
    {
        return GraphQL::type('users');
    }

     /*
    *   Declare the arguments required to create a new user
    *   arguments are id and name 
    *   id - is used to find the user
    *   name - is the field that can be updated
    */

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int())
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::find($args['id']);
        if (!$user) {
            return null;
        }

        $user->name = $args['name'];
        $user->save();

        return $user;
    }
}
