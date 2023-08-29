<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleActions;
use App\Http\Controllers\UserActions;

class TaskController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/task/add",
     *     tags={"Task API"},
     *     summary="Add new task",
     *      @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user_id", type="number", example="3"),
     *              @OA\Property(property="name", type="string", example="Complete user APIs"),
     *              @OA\Property(property="desc", type="string", example="Make user APIs CRUD..."),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and added new task",
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
     *                  default="Added Successfully!",
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

    public function addTask(Request $request){
        $data = $this->checkUser(UserActions::TASK, RoleActions::CREATE);
        if (!$data['success']) {
            return $this->sendResponse(null, false, $data['message'], 1);
        }
        Task::insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'desc' => $request->desc,
            'created_at' => Carbon::now()
        ]);

        return $this->sendResponse(null, true, "Added Successfully!");
    }

    /**
     * @OA\Post(
     *     path="/api/task/list",
     *     tags={"Task API"},
     *     summary="Get task list",
     *      @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="page", type="number", example="1"),
     *              @OA\Property(property="per_page", type="number", example="10"),
     *              @OA\Property(property="keyword", type="string", example=""),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and get task list",
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
     *                      "current_page": 1,
     *                      "data": {
     *                      {
     *                          "id": 17,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:24.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 16,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:23.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 15,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:22.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 14,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:21.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 13,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:20.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 12,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:19.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 11,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:18.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 10,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:17.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 9,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:16.000000Z",
     *                          "updated_at": null
     *                       },
     *                       {
     *                          "id": 8,
     *                          "user_id": 3,
     *                          "name": "Complete task APIs",
     *                          "desc": "Make task APIs CRUD...",
     *                          "created_at": "2023-08-29T04:39:15.000000Z",
     *                          "updated_at": null
     *                       }
     *                     },
*                          "first_page_url": "http://127.0.0.1:8000/api/task/list?page=1",
*                          "from": 1,
*                          "last_page": 2,
*                          "last_page_url": "http://127.0.0.1:8000/api/task/list?page=2",
*                          "links": {
     *                          {
         *                          "url": null,
         *                          "label": "&laquo; Previous",
         *                          "active": false
     *                          },
     *                          {
         *                          "url": "http://127.0.0.1:8000/api/task/list?page=1",
         *                          "label": "1",
         *                          "active": true
     *                          },
     *                          {
         *                          "url": "http://127.0.0.1:8000/api/task/list?page=2",
         *                          "label": "2",
         *                          "active": false
     *                          },
     *                          {
         *                          "url": "http://127.0.0.1:8000/api/task/list?page=2",
         *                          "label": "Next &raquo;",
         *                          "active": false
     *                          }
     *                        },
    *                          "next_page_url": "http://127.0.0.1:8000/api/task/list?page=2",
    *                          "path": "http://127.0.0.1:8000/api/task/list",
    *                          "per_page": 10,
    *                          "prev_page_url": null,
    *                          "to": 10,
    *                          "total": 17
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

    public function getTasks(Request $request)
    {
        $data = $this->checkUser(UserActions::TASK, RoleActions::READ);
        if (!$data['success']) {
            return $this->sendResponse(null, false, $data['message'], 1);
        }
        $user = $data['user'];
        $tasks = Task::orderBy('id', 'desc');
        $keyword = $request->keyword;

        if ($user->user_role->role == "user") {
            $tasks = $tasks->where('user_id', $user->id);
        }

        if (!empty($keyword)) {
            $tasks->where(function ($item) use ($keyword) {
                $item
                    ->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('desc', 'LIKE', "%{$keyword}%");
            });
        }
        $currentPage = $request->page;
        $itemsPerPage = $request->per_page;
        $tasks = $tasks->paginate($itemsPerPage, ['*'], 'page', $currentPage);

        return $this->sendResponse($tasks, true, "");
    }

    /**
     * @OA\Get(
     *     path="/api/task/{id}/detail",
     *     tags={"Task API"},
     *     summary="Get detail task",
     *      @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Paste task id",
     *          required=true,
     *       ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and get detail task",
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
     *                      "user_id": 3,
     *                      "name": "Complete user APIs",
     *                      "desc": "Make user APIs CRUD...",
     *                      "created_at": "2023-08-29T04:33:26.000000Z",
     *                      "updated_at": null
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
    public function detailTask($task_id){
        $data = $this->checkUser(UserActions::TASK, RoleActions::READ);
        if (!$data['success']) {
            return $this->sendResponse(null, false, $data['message'], 1);
        }
        $task = Task::where('id', $task_id)->first();

        return $this->sendResponse($task, true, "");
    }

    /**
     * @OA\Post(
     *     path="/api/task/{id}/update",
     *     tags={"Task API"},
     *     summary="Update this task",
     *      @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *      @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="Paste task id",
     *           required=true,
     *        ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user_id", type="number", example="3"),
     *              @OA\Property(property="name", type="string", example="Complete user APIs"),
     *              @OA\Property(property="desc", type="string", example="Make user APIs CRUD...1"),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and update this task",
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
     *                  default="Updated Successfully!",
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
    public function updateTask(Request $request, $task_id)
    {
        $data = $this->checkUser(UserActions::TASK, RoleActions::UPDATE);
        if (!$data['success']) {
            return $this->sendResponse(null, false, $data['message'], 1);
        }
        $task = Task::where('id', $task_id)->first();
        if ($task != null) {
            $task->update([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'desc' => $request->desc,
            ]);
            return $this->sendResponse(null, true, "Updated Successfully!");
        } else {
            return $this->sendResponse(null, false, "Task not found!");
        }

    }

    /**
     * @OA\Get(
     *     path="/api/task/{id}/delete",
     *     tags={"Task API"},
     *     summary="Delete task",
     *      @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Paste task id",
     *          required=true,
     *       ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and delete this task",
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
     *                  default="Deleted Successfully!",
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
    public function deleteTask($task_id)
    {
        $data = $this->checkUser(UserActions::TASK, RoleActions::DELETE);
        if (!$data['success']) {
            return $this->sendResponse(null, false, $data['message'], 1);
        }
        $task = Task::where('id', $task_id)->first();
        if ($task != null) {
            $task->delete();
            return $this->sendResponse(null, true, "Deleted Successfully!");
        } else {
            return $this->sendResponse(null, false, "Task not found!");
        }

    }
}
