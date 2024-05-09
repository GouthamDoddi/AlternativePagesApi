<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         // Fetch all pages from the database
         $pages = Page::all();
     
         // Convert the pages to the desired nested structure
         $nestedPages = $this->buildNestedPages($pages);
     
         // Return the nested pages in JSON format
         return response()->json(['pages' => $nestedPages], 200);
     }
     
     private function buildNestedPages($pages, $parentId = null)
     {
         $nestedPages = [];
     
         // Filter pages based on parent ID
         $filteredPages = $pages->filter(function ($page) use ($parentId) {
             return $page->parent_id === $parentId;
         });
     
         // Iterate over filtered pages and build the nested structure
         foreach ($filteredPages as $page) {
             $nestedPage = [
                 'id' => $page->id,
                 'parentId' => $page->parent_id,
                 'slug' => $page->slug,
                 'title' => $page->title,
                 'content' => $page->content,
                 'children' => $this->buildNestedPages($pages, $page->id) // Recursively build children
             ];
     
             // Add the nested page to the array
             $nestedPages[] = $nestedPage;
         }
     
         return $nestedPages;
     }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            dd($request);

            // Validate the incoming request data
            $validatedData = $request->validate([
                'slug' => 'required',
                'title' => 'required',
                'content' => 'required',
                'parentId' => 'nullable|integer', // Allow null and ensure it's an integer
            ]);
        
            // Initialize the data array with required fields
            $data = [
                'slug' => $validatedData['slug'],
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'parent_id' => $validatedData['parentId']
            ];
        
            // Add parentId to the $data array if it exists in the request
            // if ($request->filled('parentId')) {
            //     $data['parent_id'] = $request->parentId;
            // }

            // dd($data);
        
            // Create a new page with the validated data
            $page = Page::create($data);


        
            // Return the response with the created page
            return response()->json(['page' => $page], 201);
        } catch (\Exception $e) {
            // Log or print the error message
            dd($e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return response()->json(['page' => $page], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'slug' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $page = Page::findOrFail($id);
        $page->update($request->all());

        return response()->json(['message' => 'Page updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return response()->json(['message' => 'Page deleted successfully'], 200);
    }
}
