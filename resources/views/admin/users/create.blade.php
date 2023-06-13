@component('admin.layouts.content', ['title' => 'ایجاد کاربر'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">ایجاد کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد کاربر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.users.store') }}" method="post" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام کاربر</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">ایمیل</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="ایمیل را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">پسورد</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-sm-2 control-label">تکرار پسورد</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="verify" class="form-check-input" id="check">
                            <label for="check" class="form-check-label">اکانت فعال باشد</label>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت کاربر</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
