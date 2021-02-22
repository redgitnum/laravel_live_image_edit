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
    public $editWidth;
    public $height;
    public $editHeight;
    public $editSize;

    public $filters = [
        'width' => 0,
        'height' => 0,
        'aspect_ratio' => true
    ];

    protected function rules()
    {
        return [
            'filters.width' => ['required', 'min:1', 'numeric', 'max:'.$this->width],
            'filters.height' => ['required', 'min:1', 'numeric', 'max:'.$this->height],
        ];
    }

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
        $this->width = $tempImage->getWidth();
        $this->editWidth = $tempImage->getWidth();
        $this->filters['height'] = $tempImage->getHeight();
        $this->height = $tempImage->getHeight();
        $this->editHeight = $tempImage->getHeight();
        $this->editSize = '?';

    }

    public function updatedFilters()
    {
        $this->validate();

        $tempImage = Image::make($this->imageFile)
        ->resize($this->filters['width'], $this->filters['height'], function ($constraint) {
            if($this->filters['aspect_ratio']){
                $constraint->aspectRatio();
                $constraint->upsize();
            } else {
                $constraint->upsize();
            }
        });
        $this->editWidth = $tempImage->getWidth();
        $this->editHeight = $tempImage->getHeight();
        $this->imageFileEdit = $tempImage
        ->encode('data-url')
        ->getEncoded();
        $this->editSize = intval(mb_strlen($this->imageFileEdit, '8bit')*0.75/1024);

    }
}
