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
                    @endif
                </div>
                @error('imageFile')
                    <div class="text-xs uppercase text-red-500 py-1">{{ $message }}</div>
                @enderror

                {{-- FILTERS --}}
                <div class="p-4 flex flex-col items-end">
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
                    @endif
                </div>
                

                {{-- EDIT PREVIEW --}}
                <div class="p-4 flex-1 flex flex-col @if($imageFile)border border-gray-400 rounded @endif">
                    @if ($imageFileEdit)
                    Edit Preview:
                    <div class="flex flex-col justify-center items-center h-full">
                        <img src="{{ $imageFileEdit }}">
                    </div>
                    @endif
                </div>

            </div>
        </div>
        
    </div>
