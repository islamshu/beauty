<div class="container mt-4">
    <h2 class="mb-4">ادارة التصنيفات</h2>

    <div class="card p-3">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
            <div class="mb-3">
                <label class="form-label">اسم التصنيف</label>
                <input type="text" wire:model="title" class="form-control">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary" >
                {{ $isEdit ? 'Update' : 'Create' }}
            </button>

            @if($isEdit)
                <button type="button" wire:click="resetForm" class="btn btn-secondary">حذف</button>
            @endif
        </form>
    </div>

    <div class="mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الاجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" wire:click="edit({{ $category->id }})">تعديل</button>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $category->id }})"
                                onclick="return confirm('Are you sure?')">حذف</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
