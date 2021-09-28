<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{

    public $posts, $nombre, $apellidos, $area, $cargo, $post_id;
    public $isOpen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->nombre = '';
        $this->apellidos = '';
        $this->area = '';
        $this->cargo = '';
        $this->post_id = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'area' => 'required',
            'cargo' => 'required',
        ]);
   
        Post::updateOrCreate(['id' => $this->post_id], [
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'area' => $this->area,
            'cargo' => $this->cargo,
        ]);
  
        session()->flash('message', 
            $this->post_id ? 'Se actualizo correctamente.' : 'Se creo correctamente.');
  
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->nombre = $post->nombre;
        $this->apellidos = $post->apellidos;
        $this->area = $post->area;
        $this->cargo = $post->cargo;
    
        $this->openModal();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Se elimino correctamente.');
    }
}
