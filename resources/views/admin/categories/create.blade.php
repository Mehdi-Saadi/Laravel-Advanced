@component('admin.layouts.content', ['title' => 'ایجاد دسته بندی'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ایجاد دسته بندی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد دسته بندی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.categories.store') }}" method="post" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام دسته</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" autocomplete="off">
                        </div>
                        @if(request('parent'))
                            @php
                            $parent = \App\Models\Category::find(request('parent'));
                            @endphp

                            <div class="form-group">
                                <label for="parent" class="col-sm-2 control-label">دسته اصلی</label>
                                <input type="text" id="parent" class="form-control" disabled value="{{ $parent->name }}">
                                <input type="hidden" name="parent" value="{{ $parent->id }}">
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت دسته</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
