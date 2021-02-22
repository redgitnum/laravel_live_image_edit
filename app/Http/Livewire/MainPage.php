<?php

namespace App\Http\Livewire;

use Dotenv\Exception\ValidationException;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class MainPage extends Component
{
    use WithFileUploads;

    public $imageFile = null;
    public $imageFileEdit;

    public $width;
    public $height;
    public $filters = [
        'width' => 0,
        'height' => 0,
        'aspect_ratio' => true
    ];

    protected $rules = [
        'filters.width' => 'required|min:1|numeric',
        'filters.height' => 'required|min:1|numeric',
    ];

    public function render()
    {
        return view('livewire.main-page');
    }

    public function updatedImageFile($value)
    {

        $extension = pathinfo($value->getFilename(), PATHINFO_EXTENSION);
        if (!in_array($extension, ['png', 'jpg', 'jpeg', 'bmp', 'gif'])) {
            $this->reset();
        }

        $this->validate([
            'imageFile' => 'mimes:png,jpg,jpeg,bmp,gif|max:1024',
        ]);
        $tempImage = Image::make($this->imageFile);
        $this->imageFileEdit = $tempImage->encode('data-url')->getEncoded();
        $this->filters['width'] = $tempImage->getWidth();
        $this->filters['height'] = $tempImage->getHeight();
    }

    public function updatedFilters()
    {
        $this->validate();

        $this->imageFileEdit = Image::make($this->imageFile)
        ->resize($this->filters['width'], $this->filters['height'], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->encode('data-url')
        ->getEncoded();
    }
}
