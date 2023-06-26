@component('admin.layouts.content', ['title' => 'ایجاد مقام'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">همه مقام ها</a></li>
        <li class="breadcrumb-item active">ایجاد مقام</li>
    @endslot

    @slot('script')
        <script>
            $('#permissions').select2({
                'placeholder': 'دسترسی مورد نظر را انتخاب کنید'
            })
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد مقام</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.roles.store') }}" method="post" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">عنوان مقام</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="عنوان مقام را وارد کنید" autocomplete="off" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="label" class="col-sm-2 control-label">توضیح مقام</label>
                            <input type="text" name="label" class="form-control" id="label" placeholder="توضیح مقام را وارد کنید" autocomplete="off" value="{{ old('label') }}">
                        </div>
                        <div class="form-group">
                            <label for="permissions" class="col-sm-2 control-label">دسترسی ها</label>
                            <select class="form-control" name="permissions[]" id="permissions" multiple>
                                @foreach(\App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }} - {{ $permission->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت مقام</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
