<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subCategories = SubCategory::all();
        return response()->view('cms.subCategories.index', ['subCategories' => $subCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return response()->view('cms.subCategories.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'category_id' => 'required|numeric|exists:categories,id',
            'name' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $subCategory = new SubCategory();
            $subCategory->category_id = $request->input('category_id');
            $subCategory->name = $request->input('name');
            $isSaved = $subCategory->save();
            return response()->json(
                ['message' => $isSaved ? 'Save successfully' : 'Save Failed'],
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
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
        $categories = Category::all();
        return response()->view('cms.subCategories.edit',
            ['subCategory' => $subCategory, 'categories' => $categories]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
        $validator = Validator($request->all(), [
            'category_id' => 'required|numeric|exists:categories,id',
            'name' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $subCategory->category_id = $request->input('category_id');
            $subCategory->name = $request->input('name');
            $isSaved = $subCategory->save();
            return response()->json(
                ['message' => $isSaved ? 'Save successfully' : 'Save Failed'],
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
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
        $isDeleted = $subCategory->delete();
        return response()->json(
            ['message' => $isDeleted ? 'Delete successfully' : 'Delete Failed'],
            $isDeleted ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST
        );
    }
}
