<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return response()->view('cms.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        return response()->view('cms.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $category = new Category();
            $category->name = $request->input('name');
            $isSaved = $category->save();
            return response()->json(
                ['message' => $isSaved ? 'Save successfully' : 'Save Failed'],
                $isSaved ? Response::HTTP_CREATED :Response::HTTP_BAD_REQUEST
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
    public function show(Category $category)
    {
        //
        $subCategories = $category->subCategories;
        return response()->json(['subCategories' => $subCategories]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return response()->view('cms.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $category->name = $request->input('name');
            $isSaved = $category->save();
            return response()->json(
                ['message' => $isSaved ? 'Save successfully' : 'Save Failed'],
                $isSaved ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $isDeleted = $category->delete();
        return response()->json(
            ['message' => $isDeleted ? 'Delete successfully' : 'Delete Failed'],
            $isDeleted ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST
        );
    }
}
