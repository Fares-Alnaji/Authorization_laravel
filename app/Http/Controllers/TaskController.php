<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (auth('user-api')->check()) {
            // $tasks = Task::where('user_id', '=', auth('user-api')->user()->id)->get(); //Or
            $tasks = auth('user-api')->user()->tasks;

            // return new TaskResourceCollection($tasks);
            // return new TaskResource($tasks[0]);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => new TaskResourceCollection($tasks)
            ]);
        } else if (auth('user')->check()) {
            $tasks = Task::where('user_id', '=', auth('user')->user()->id)->get(); //Or
            // $tasks = auth('user')->user()->tasks;
            return response()->view('cms.tasks.index', ['tasks' => $tasks]);
        } else {
            $tasks = Task::all();
            return response()->view('cms.tasks.index', ['tasks' => $tasks]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        $users = User::all();
        return response()->view('cms.tasks.create', ['categories' => $categories, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'user_id' => 'nullable|numeric|exists:users,id',
            'sub_category_id' => 'required|numeric|exists:sub_categories,id',
            'title' => 'required|string',
            'info' => 'required|string',
            'task_image' => 'required|image|mimes:jpg,png|max:1024',
        ]);

        if (!$validator->fails()) {
            $task = new Task();
            $task->title = $request->input('title');
            $task->info = $request->input('info');
            $task->sub_category_id = $request->input('sub_category_id');
            // User!!!!
            if (auth('admin')->check()) {
                $task->user_id = $request->input('user_id');
            } else {
                $task->user_id = $request->user()->id;
            }
            if($request->hasFile('task_image')) {
                $image = $request->file('task_image');
                $imageName = time() . '_task_image.' . $image->extension();
                $image->storeAs('tasks' , $imageName , ['disk' => 'public']);
                $task->image = 'tasks/' . $imageName;
            }

            $isSaved = $task->save();
            return response()->json(
                ['message' => $isSaved ? 'Created Successfully' : 'Create Failed'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $isDeleted = $task->delete();
        return response()->json(
            ['message' => $isDeleted ? 'Delete successfully' : 'Delete Failed'],
            $isDeleted ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST
        );
    }
}
