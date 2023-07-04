@component('admin.layouts.content', ['title' => 'ویرایش دسته بندی'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسته بندی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسته بندی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام دسته</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" autocomplete="off" value="{{ old('name', $category->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="parent" class="col-sm-2 control-label">دسته مرتبط</label>
                            <select class="form-control" name="parent" id="parent">
                                @foreach(\App\Models\Category::where('id', '<>', $category->id)->get() as $cate)
                                    <option value="{{ $cate->id }}" {{ $cate->id === $category->parent  ? 'selected' : '' }}>{{ $cate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش دسته</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
