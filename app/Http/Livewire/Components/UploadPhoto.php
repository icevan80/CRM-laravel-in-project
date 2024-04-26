<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadPhoto extends Component
{

    use withFileUploads;

    public $image = false;
    public $image_value = null;
    public string $tag_name = '';

    public function mount($tag = 'image', $source = null)
    {
        if ($source != null) {
            $this->fill(['image' => $source]);
        }
        $this->fill(['tag_name' => $tag]);
    }

    protected function rules()
    {
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {

            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,svg,gif,webp|max:204800';
        } else {
            $rules['image'] = 'required|string|min:1|max:255';
        }
        return $rules;
    }

    public function updatedImage()
    {
        if (is_string($this->image_value)) {

            Storage::delete('public/' . $this->image_value);
        }
        $this->image_value = $this->image->store('images', 'public');
    }


    public function render()
    {
        return view('livewire.components.upload-photo', ['tag' => $this->tag_name, 'image_value' => $this->image_value]);
    }
}
