@component('admin.layouts.content', ['title' => 'دسترسی ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        @if(request()->fullUrl() === route('admin.permissions.index'))
            <li class="breadcrumb-item active">لیست دسترسی ها</li>
        @else
            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست دسترسی ها</a></li>
        @endif
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">دسترسی ها</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-2">
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-info">ایجاد دسترسی جدید</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>نام دسترسی</th>
                                <th>توضیح دسترسی</th>
                                <th>اقدامات</th>
                            </tr>

                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->label }}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger ml-1">حذف</button>
                                        </form>
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $permissions->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
