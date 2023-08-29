<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\AppUserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppUserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/app/user/auth/registration",
     *     tags={"User API"},
     *     summary="Register user",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="role", type="string", example="admin"),
     *              @OA\Property(property="username", type="string", example="Abdullajon"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Registration user and to login.",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example={
     *                      "username": "Abdullajon",
     *                      "password": "$2y$10$sZZUV7ykVyAXT7/eDzGyReThtdkaLUK9jknrDEDNaeK71uKeQkfiO",
     *                      "token": "ms7ST2opzINdvWCxLanr8zg21kOKFS",
     *                      "updated_at": "2023-08-28T11:58:12.000000Z",
     *                      "created_at": "2023-08-28T11:58:12.000000Z",
     *                      "id": 1
     *                  }
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Login!",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */
    public function registerAppUser(Request $request)
    {
        $check_app_user = AppUser::where('username', $request->username)->first();
        if ($check_app_user != null) {
            return $this->sendResponse(null, false, "Username found!");
        }
        $password = Hash::make($request->password);
        $token = Str::random(30);
        $app_user = AppUser::create([
            'username' => $request->username,
            'password' => $password,
            'token' => $token
        ]);
        AppUserRole::insert([
            'user_id' => $app_user->id,
            'role' => $request->role
        ]);
        return $this->sendResponse($app_user, true, "Login!");
    }


    /**
     * @OA\Post(
     *     path="/api/app/user/auth/login",
     *     tags={"User API"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="Abdullajon"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **username** & **password** and to login.",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example={
     *                      "id": 1,
     *                      "username": "Abdullajon",
     *                      "password": "$2y$10$sZZUV7ykVyAXT7/eDzGyReThtdkaLUK9jknrDEDNaeK71uKeQkfiO",
     *                      "token": "1XkHdP6TEgxACHCJlGsn4EitiPTIVB",
     *                      "created_at": "2023-08-28T11:58:12.000000Z",
     *                      "updated_at": "2023-08-28T12:03:25.000000Z"
     *                  }
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Login!",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */

    public function loginAppUser(Request $request)
    {
        $check_app_user = AppUser::where('username', $request->username)->first();
        if ($check_app_user == null) {
            return $this->sendResponse(null, false, "User not found!", 1);
        }
        if (Hash::check($request->password, $check_app_user->password) === FALSE) {
            return $this->sendResponse(null, false, "Wrong password!");
        } else {
            $token = Str::random(30);
            $check_app_user->update([
                'token' => $token
            ]);
            $check_app_user = AppUser::where('id', $check_app_user->id)->first();

            return $this->sendResponse($check_app_user, true, "Login!");
        }
    }

    /**
     * @OA\Get(
     *     path="/api/app/user/get",
     *     tags={"User API"},
     *     summary="Get user",
     *     @OA\Parameter(
     *          name="Token",
     *          in="header",
     *          description="User token",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and get this user.",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example={
     *                      "id": 1,
     *                      "username": "Abdullajon",
     *                      "password": "$2y$10$sZZUV7ykVyAXT7/eDzGyReThtdkaLUK9jknrDEDNaeK71uKeQkfiO",
     *                      "token": "1XkHdP6TEgxACHCJlGsn4EitiPTIVB",
     *                      "created_at": "2023-08-28T11:58:12.000000Z",
     *                      "updated_at": "2023-08-28T12:03:25.000000Z"
     *                  }
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */

    public function getAppUser(){
        $check_app_user = AppUser::where('token', $this->getToken())->with('setStaticColumn')->first();
        if ($check_app_user == null) {
            return $this->sendResponse(null, false, "User not found!", 1);
        }

        return $this->sendResponse($check_app_user, true, "");
    }


    /**
     * @OA\Get(
     *     path="/api/app/user/list",
     *     tags={"User API"},
     *     summary="Get user list",
     *     @OA\Parameter(
     *          name="Token",
     *          in="header",
     *          description="User token",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and get user list.",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example={
     *                      {
     *                          "id": 2,
     *                          "username": "Ali",
     *                          "password": "$2y$10$wnBgNzXvguR0QSAWJ9AehOnkKr1xzHTREEYOngzoUxZb0QC0cPQai",
     *                          "token": "8stomirSGdmP4TJPcML1gYBtAFsuYC",
     *                          "created_at": "2023-08-29T04:00:55.000000Z",
     *                          "updated_at": "2023-08-29T04:00:55.000000Z"
     *                       },
     *                       {
     *                          "id": 3,
     *                          "username": "Vali",
     *                          "password": "$2y$10$2gNZL7TnXp4RgcCWvGzjn.EgaOcAWrZgaLgi662ylRUVuA/CsYj1q",
     *                          "token": "QG45GsPO2CyMalWJjE2Cm2UPEpA0Yp",
     *                          "created_at": "2023-08-29T04:01:23.000000Z",
     *                          "updated_at": "2023-08-29T04:01:23.000000Z"
     *                       }
     *                  }
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */

    public function getAppUsers(){
        $check_app_user = AppUser::where('token', $this->getToken())->first();
        if ($check_app_user == null) {
            return $this->sendResponse(null, false, "User not found!", 1);
        }

        $app_users = AppUser::where('id', '!=', $check_app_user->id)->get();
        return $this->sendResponse($app_users, true, "");
    }

    /**
     * @OA\Get(
     *     path="/api/app/user/auth/logout",
     *     tags={"User API"},
     *     summary="Logout user",
     *     @OA\Parameter(
     *          name="Token",
     *          in="header",
     *          description="User token",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and logout this user.",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example=null
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Logout!",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="1",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */

    public function logoutAppUser()
    {
        $check_app_user = AppUser::where('token', $this->getToken())->first();
        if ($check_app_user == null) {
            return $this->sendResponse(null, false, "User not found!", 1);
        }

        $check_app_user->update([
            'token' => null
        ]);
        return $this->sendResponse(null, true, "Logout!", 1);
    }
}
