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
        'aspect_ratio' => true,
        'text' => '',
        'textX' => 0,
        'textY' => 0,
        'textSize' => 48,
        'textColor' => '#fdf6e3',
        'imageR' => 0,
        'imageG' => 0,
        'imageB' => 0,
        'imageContrast' => 0,
        'imageBrightness' => 0,
        'imageGamma' => 1,
        'pixelate' => 0
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
        //RESISING OPTIONS
        ->resize($this->filters['width'], $this->filters['height'], function ($constraint) {
            if($this->filters['aspect_ratio']){
                $constraint->aspectRatio();
                $constraint->upsize();
            } else {
                $constraint->upsize();
            }
        })
        //TEXT MANIPULATION OPTIONS
        ->text($this->filters['text'], $this->filters['textX'], $this->filters['textY'], function($font) {
            $root = dirname(__DIR__,3);
            $font->file($root.'/resources/fonts/arial.ttf');
            $font->size($this->filters['textSize']);
            $font->color($this->filters['textColor']);
            $font->valign('top');
        })
        //COLORIZING IMAGE
        ->colorize($this->filters['imageR'], $this->filters['imageG'], $this->filters['imageB'])
        //IMAGE ADJUSTMENST
        ->contrast($this->filters['imageContrast'])
        ->gamma($this->filters['imageGamma'])
        ->brightness($this->filters['imageBrightness'])
        ->pixelate($this->filters['pixelate']);

        //GET RESULT IMAGE DIMENSIONS
        $this->editWidth = $tempImage->getWidth();
        $this->editHeight = $tempImage->getHeight();

        //MAKE ENCODED IMAGE FOR PREVIEW
        $this->imageFileEdit = $tempImage
        ->encode('data-url')
        ->getEncoded();

        //GET RESULT APPROXIMATE FILESIZE
        $this->editSize = intval(mb_strlen($this->imageFileEdit, '8bit')*0.75/1024);

    }

    public function downloadImage()
    {
        $image = Image::make($this->imageFileEdit)->encode('jpg');
        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename=image.jpg',
        ];

        return response()->stream(function() use ($image) {
            echo $image;
        }, 200, $headers);
    }
}
