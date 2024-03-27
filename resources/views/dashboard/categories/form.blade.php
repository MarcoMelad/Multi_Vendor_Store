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
        <x-form.input label="Category Name" name="name" :value="$category->name"/>
    </div>
    <div class="form-group">
        <label for="">Category Parent</label>
        <select name="parent_id" class="form-control form-select">
            <option value="">Primary Category</option>
            @foreach($parents as $parent)
                <option
                    value="{{$parent->id}}"
                    @selected(old('parent_id',($category->parent_id) == $parent->id)) >{{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <x-form.textarea name="description" label="Description" :value="$category->description"/>
    </div>
    <div class="form-group">
        <x-form.label>Image</x-form.label>
        <x-form.input type="file" name="image" accept="image/*"/>
    </div>
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <x-form.radio name="status" :checked="$category->status" :options="['active'=> 'Active', 'archived' => 'Archived']" />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-outline-primary">Save</button>
    </div>
</div>
