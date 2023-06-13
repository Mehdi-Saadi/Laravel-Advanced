@component('admin.layouts.content', ['title' => 'پنل مدیریت'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active">پنل مدیریت</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
    @endslot

    <h2>users list</h2>

@endcomponent
