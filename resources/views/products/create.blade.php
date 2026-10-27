<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create product</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock</label>
                            <input id="stock_quantity" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('stock_quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                                Available for sale
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
