<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;
    public $search;

    public function create()
    {
        $input = $this->validateOnly('name');

        Todo::create($input);

        $this->reset('name');

        session()->flash('success', 'Todo Created!');
    }

    public function delete($todoId)
    {
        Todo::find($todoId)->delete();
    }

    public function render()
    {
        return view('livewire.todo-list',
    ['todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)]);
    }
}
