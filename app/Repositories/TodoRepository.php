<?php
namespace App\Repositories;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function all()
    {
        return Todo::sortable()->paginate(10);
    }

    public function store(array $data)
    {
        
        Todo::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image'],
                'is_completed' => 0
            ]);
    }

    public function find($id)
    {
        return Todo::find($id);
    }

    public function update(array $data)
    {
        
        Todo::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $data['image'],
                'is_completed' => 0
            ]);
    }

    public function delete($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
    }
}
