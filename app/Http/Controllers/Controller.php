<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use OpenApi\Attributes as OA;
/**
 * @OA\Info(
 *     title="TASK MANAGER API",
 *     version="1.0"
 * )
 */

abstract class Roles
{
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const USER = 'user';
}

abstract class UserActions
{
    const TASK = 'task';
}

abstract class RoleActions
{
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';
}

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $action_roles = [
        Roles::ADMIN => [
            UserActions::TASK => [
                RoleActions::READ,
                RoleActions::CREATE,
                RoleActions::UPDATE,
                RoleActions::DELETE,
            ],
        ],
        Roles::MANAGER => [
            UserActions::TASK => [
                RoleActions::READ,
                RoleActions::UPDATE,
            ],
        ],
        Roles::USER => [
            UserActions::TASK => [
                RoleActions::READ,
                RoleActions::CREATE,
            ],
        ],
    ];
    public function checkUser($currentAction, $currentActionType)
    {
        $app_user = AppUser::where('token', $this->getToken())->first();
        $accessAction = false;
        if ($app_user != null) {
            foreach ($this->action_roles as $key => $role) {
                if ($key == $app_user->user_role->role) {
                    foreach ($role as $key => $action) {
                        if ($key == $currentAction) {
                            foreach ($action as $key) {
                                if ($key == $currentActionType) {
                                    $accessAction = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        $message = "";
        if ($app_user == null) {
            $message = "User not found!";
        } else if (!$accessAction) {
            $message = "Access not found!";
        }

        return [
            'success' => $accessAction && $app_user != null,
            'message' => $message,
            'access' => $accessAction,
            'user' => $accessAction ? $app_user : null,
        ];
    }
    public function sendResponse($result, $success = NULL, $message = NULL, $error_code = 0)
    {
        $response = [
            'success' => $success,
            'data' => $result,
            'message' => $message,
            'error_code' => $error_code,

        ];

        return response()->json($response, 200);
    }

    public function getToken()
    {
        $headers = getallheaders();
        return (isset($headers['Token'])) ? $headers['Token'] : 'token';
    }
}
