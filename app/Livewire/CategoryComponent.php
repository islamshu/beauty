<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryComponent extends Component
{
    public $categories, $name, $category_id;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.category-component')->layout('layouts.master');
    }

    public function store()
    {
        $this->validate();
        
        Category::create([
            'name' => $this->name,
        ]);


        $this->resetForm();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->category_id);
        $category->update([
            'name' => $this->name,
        ]);

        $this->resetForm();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->category_id = null;
        $this->isEdit = false;
    }
}
