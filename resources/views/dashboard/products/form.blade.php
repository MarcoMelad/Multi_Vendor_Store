@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
    <div class="form-group">
        <x-form.input label="Product Name" name="name" :value="$product->name"/>
    </div>
    <div class="form-group">
        <label for="">Category</label>
        <select name="category_id" class="form-control form-select">
            <option value="">Primary Category</option>
            @foreach(App\Models\Category::all() as $category)
                <option
                    value="{{$category->id}}"
                    @selected(old('category_id',$product->category_id) == $category->id)>{{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <x-form.textarea name="description" label="Description" :value="$product->description"/>
    </div>
    <div class="form-group">
        <x-form.label>Image</x-form.label>
        <x-form.input type="file" name="image" accept="image/*"/>
        @if($product->image)
            <img src="{{ asset('storage/'. $product->image) }}" alt="" height="60">
        @endif
    </div>
    <div class="form-group">
        <x-form.input name="price" label="Price" :value="$product->price"/>
    </div>
    <div class="form-group">
        <x-form.input name="compare_price" label="Compare Price" :value="$product->compare_price"/>
    </div>
    <div class="form-group">
        <x-form.input name="tags" label="Tags" :value="$tags"/>
    </div>
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <x-form.radio name="status" :checked="$product->status"
                          :options="['active'=> 'Active', 'draft'=> 'Draft','archived' => 'Archived']"/>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-outline-primary">Save</button>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify(inputElm);
    </script>
@endpush
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css"/>
@endpush
