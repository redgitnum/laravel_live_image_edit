    <div class="w-full flex min-h-screen">
        <div class="bg-blue-50 p-4 w-full justify-center">
            <div class="flex flex-col items-center justify-center mb-10">
                <h1 class="text-lg text-center mb-2">Select image to edit</h1>
                <input type="file" wire:model="imageFile" name="imageFile2">
            </div>
            <div class="flex">

                {{-- ORIGINAL PREVIEW --}}
                <div class="p-4 flex-1 flex flex-col @if($imageFile)border border-gray-400 rounded @endif">
                    @if ($imageFile)
                    Original Image Preview:
                    <div class="flex flex-col justify-center items-center h-full">
                        <img src="{{ $imageFile->temporaryUrl() }}">
                    </div>
                    <div class="text-center">{{ $width.'x'.$height.' px - '. intval($this->imageFile->getSize()/1024) .' KB' }}</div>
                    @endif
                </div>
                @error('imageFile')
                    <div class="text-xs uppercase text-red-500 py-1">{{ $message }}</div>
                @enderror

                {{-- FILTERS --}}
                <div class="px-4 flex flex-col items-end gap-2">
                    @if ($imageFile)

                    {{-- IMAGE DIMENSIONS --}}
                    <div class="border rounded border-gray-400 p-2 flex flex-col items-end w-72">
                        <label>Width: 
                            <input type="number" wire:model.lazy="filters.width" class="p-2 rounded mb-2">
                        </label>
                        @error('filters.width')
                            <div class="text-xs uppercase text-red-500 py-1">{{ $message }}</div>
                        @enderror

                        <label>Height: 
                            <input type="number" wire:model.lazy="filters.height" class="p-2 rounded mb-2">
                        </label>
                        @error('filters.height')
                            <div class="text-xs uppercase text-red-500 py-1">{{ $message }}</div>
                        @enderror

                        <label class="relative flex items-center pr-8 group" wire:click="$toggle('filters.aspect_ratio')">Keep aspect ratio: 
                            <input type="checkbox" wire:model="filters.aspect_ratio" class="hidden">
                            <div class="absolute right-0 bg-white h-full w-6 rounded shadow group-hover:bg-blue-100">
                                @if($filters['aspect_ratio'])
                                    <div class="bg-blue-400 inset-1 rounded absolute"></div>
                                @endif
                            </div>
                        </label>
                        @error('filters.aspect_ratio')
                        <div class="text-xs uppercase text-red-500 py-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- ADD TEXT TO IMAGE --}}
                    
                    <div class="border rounded border-gray-400 p-2 flex flex-col items-end w-72">
                        <label>Text: 
                            <input type="text" wire:model.lazy="filters.text" class="p-2 rounded mb-2">
                        </label>
                        <div class="flex justify-between mb-2">
                            <label>Size:
                                <input type="number" wire:model.lazy="filters.textSize" class="p-2 rounded w-14 mr-2">
                            </label>
                            <label class="mt-1.5">Color:
                                <input type="color" wire:model.lazy="filters.textColor" class="p-2 rounded w-14">
                            </label>
                        </div>
                        <div class="flex justify-between">
                            <label>X cord:
                                <input type="number" wire:model.lazy="filters.textX" class="p-2 rounded w-14 mr-2">
                            </label>
                            <label>Y cord:
                                <input type="number" wire:model.lazy="filters.textY" class="p-2 rounded w-14">
                            </label>
                        </div>
                    </div>

                    {{-- IMAGE COLOR MANIPULATION --}}
                    
                    <div class="border rounded border-gray-400 p-2 flex flex-col items-end w-72">
                        <label class="text-red-600 flex gap-2">Red: 
                            <input type="range" min="-100" max="100" wire:model.lazy="filters.imageR" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['imageR'] }}</span>
                        </label>
                        <label class="text-blue-600 flex gap-2">Blue: 
                            <input type="range" min="-100" max="100" wire:model.lazy="filters.imageB" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['imageB'] }}</span>
                        </label>
                        <label class="text-green-600 flex gap-2">Green: 
                            <input type="range" min="-100" max="100" wire:model.lazy="filters.imageG" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['imageG'] }}</span>
                        </label>
                    </div>

                    {{-- IMAGE ADJUSTMENTS --}}
                    
                    <div class="border rounded border-gray-400 p-2 flex flex-col items-end w-72">
                        <label class="flex gap-2">Contrast: 
                            <input type="range" min="-100" max="100" wire:model.lazy="filters.imageContrast" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['imageContrast'] }}</span>
                        </label>
                        <label class="flex gap-2">Brightness: 
                            <input type="range" min="-100" max="100" wire:model.lazy="filters.imageBrightness" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['imageBrightness'] }}</span>
                        </label>
                        <label class="flex gap-2">Gamma: 
                            <input type="range" min="0.1" max="2" step="0.1" wire:model.lazy="filters.imageGamma" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['imageGamma'] }}</span>
                        </label>
                        <label class="flex gap-2">Pixelate: 
                            <input type="range" min="0" max="50" wire:model.lazy="filters.pixelate" class="w-36">
                            <span class="w-7 pr-2 text-right">{{ $filters['pixelate'] }}</span>
                        </label>
                    </div>

                    @endif
                </div>
                

                {{-- EDIT PREVIEW --}}
                <div class="p-4 flex-1 flex flex-col @if($imageFile)border border-gray-400 rounded @endif">
                    @if ($imageFileEdit)
                    Edit Preview:
                    <div class="flex flex-col justify-center items-center h-full">
                        <img src="{{ $imageFileEdit }}">
                    </div>
                    <div class="text-center">{{ $editWidth.'x'.$editHeight.' px - ~'. $this->editSize .' KB' }}</div>

                    @endif
                </div>

            </div>
        </div>
        
    </div>
