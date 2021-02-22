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
                <div class="p-4 flex flex-col items-end gap-2">
                    @if ($imageFile)

                        <label>Width: 
                            <input type="number" wire:model.lazy="filters.width" class="p-2 rounded">
                        </label>
                        @error('filters.width')
                            <div class="text-xs uppercase text-red-500 py-1">{{ $message }}</div>
                        @enderror

                        <label>Height: 
                            <input type="number" wire:model.lazy="filters.height" class="p-2 rounded">
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
