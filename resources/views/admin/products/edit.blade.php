@component('admin.layouts.content', ['title' => 'ویرایش محصول'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ویرایش محصول</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام محصول</label>
                            <input type="text" name="title" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('title', $product->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea id="description" name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="قیمت را وارد کنید" value="{{ old('price', $product->price) }}">
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="number" name="inventory" class="form-control" id="inventory" placeholder="موجودی را وارد کنید" value="{{ old('inventory', $product->inventory) }}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش محصول</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
