<?php

namespace App\Http\Controllers;
use App\Http\Resources\ToDoListResource;
use App\Models\ToDoList;
use App\Models\TodoMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ToDoListController extends Controller
{
   
    public function api()
    {
        $todoLists = ToDoListResource::collection(ToDoList::with('todoMedia')->get());
        return response()->json($todoLists);
    }

    public function index()
    {
        $toDoLists = ToDoList::all();

        return view('todo.index', compact('toDoLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /*   dd($request); 
      
       "document" => array:2 [▼
        0 => "1711438338-66027a02a16cc_294023271_1117927519141895_4645182981204663884_n.jpg"
        1 => "1711438346-66027a0a109f9_Screenshot 2024-02-24 201812.png"
      ]
      testing
      
      */
        /*         
       $data = $request->all();
    
       ToDoList::create($data);
       worked
        */
        $toDoList = new ToDoList();
        $toDoList->date = $request->date;
        $toDoList->time = $request->time;

        $toDoList->title = $request->title;
        $toDoList->description = $request->description;

        $toDoList->save();

        $files = $request->document;
        if ($files != null) {
            /* in my below codes.. It always expects data in files.. so i made a barrer. */
            foreach ($files as $file) {
                $toDoListId = $toDoList->id;
                $TodoMedia = new TodoMedia();
                $TodoMedia->toDoListId = $toDoListId;
                $TodoMedia->file = $file;
                $TodoMedia->save();
            }
        }



        return redirect()->route('todo.index')->with('success', 'ToDo added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $toDoList = ToDoList::findOrFail($id);
        return view('todo.show', compact('toDoList'));
    }

    public function edit($id)
    {
        $toDoList = ToDoList::findOrFail($id);
        return view('todo.edit', compact('toDoList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


        $toDoList = ToDoList::findOrFail($id);

        // Update the attributes of the ToDoList model instance
        $toDoList->date = $request->date;
        $toDoList->time = $request->time;
        $toDoList->title = $request->title;
        $toDoList->description = $request->description;

        // Save the changes to the database
        $toDoList->save();

        TodoMedia::where('toDoListId', $toDoList->id)->delete();

        $files = $request->document;
        if ($files != null) {
            /* in my below codes.. It always expects data in files.. so i made a barrer. */
            foreach ($files as $file) {
                $toDoListId = $toDoList->id;
                $TodoMedia = new TodoMedia();
                $TodoMedia->toDoListId = $toDoListId;
                $TodoMedia->file = $file;
                $TodoMedia->save();
            }
        }


        // Redirect to the index page
        return redirect()->route('todo.index')->with('success', 'ToDo updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the ToDoList item by its ID
        $toDoList = ToDoList::findOrFail($id);

        // Delete the ToDoList item
        $toDoList->delete();

        // Redirect to a relevant page
        return redirect()->route('todo.index')->with('success', 'ToDo deleted successfully');
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = time() . '-' . uniqid() . '_' . str_replace(' ', '', $file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
    
    public function deleteFile(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $filename = $data['filename'];


        if ($filename !== null) {
            // Delete the file from the storage
            Storage::delete('public/uploads/' . $filename);

            return response()->json(['message' => 'File deleted successfully']);
        } else {
            return response()->json(['message' => 'Filename is null'], 400);
        }
    }


    public function fetchApi(){
        return view('todo.fetchApi');
    }
  
}
