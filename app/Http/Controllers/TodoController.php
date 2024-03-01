<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\TodoRepositoryInterface;


class TodoController extends Controller
{
    private $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function index()
    {
        // $todos = Todo::all();
        // $todos = Todo::sortable()->paginate(10);
        $todos = $this->todoRepository->all();
        return view('todos.index',[
            'todos' => $todos
        ]);
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(TodoRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3|max:255',
            'description' => 'required|string',
            'image'     => 'required',
            // 'image' => 'nullable|mimes:png,jpg,jpeg,webp',
        ]);
      

        if($request->has('image'))
        { 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'uploads/todo/';
            $file->move($path,$filename);
        }

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else
        {
            // Todo::create([
            //     'title' => $request->title,
            //     'description' => $request->description,
            //     'image' => $path.$filename,
            //     'is_completed' => 0
            // ]);
            $data = $request->all();
            $data['image'] = $path.$filename;

            $this->todoRepository->store($data);

            $request->session()->flash('alert-success','Todo Created Successfully');

            return to_route('todos.index');
        }
    }

    public function show($id)
    {
        $todo = $this->todoRepository->find($id);
        if(! $todo)
        {
            request()->session()->flash('error','Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.show',['todo' => $todo]);
    }

    public function edit($id)
    {
        $todo = $this->todoRepository->find($id);
        if(! $todo)
        {
            request()->session()->flash('error','Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.edit',['todo' => $todo]);
    }

    public function update(TodoRequest $request)
    {
        $todo = $this->todoRepository->find($request->todo_id);
        if(! $todo)
        {
            request()->session()->flash('error','Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }

        // dd($request->is_completed);

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3|max:255',
            'description' => 'required|string',
            'image'     => 'nullable',
            'is_completed' => 'required',
        ]);

        if($request->has('image'))
        { 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'uploads/todo/';
            $file->move($path,$filename);
        }

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else
        {

            // $todo->update([
            //     'title' => $request->title,
            //     'description' => $request->description,
            //     'image' => $path.$filename,
            //     'is_completed' => $request->is_completed
            // ]);

            $data = $request->all();
            $data['image'] = $path.$filename;

            $this->todoRepository->update($data);

            $request->session()->flash('alert-info','Todo Updated Successfully');
            return to_route('todos.index');
        }
    }

    public function destroy(Request $request)
    {
        $todo = $this->todoRepository->find($request->todo_id);
        if(! $todo)
        {
            request()->session()->flash('error','Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }

        $this->todoRepository->delete($request->todo_id);
        $request->session()->flash('alert-success','Todo Deleted Successfully');
        return to_route('todos.index');
    }
}
