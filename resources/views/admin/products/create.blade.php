@component('admin.layouts.content', ['title' => 'ایجاد محصول'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ایجاد محصول</li>
    @endslot

    @slot('script')
        <script>
            $('#categories').select2({
                'placeholder' : 'دسترسی مورد نظر را انتخاب کنید'
            })

            let changeAttributeValues = (event , id) => {
                let valueBox = $(`select[name='attributes[${id}][value]']`);

                $.ajaxSetup({
                    headers : {
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type' : 'application/json'
                    }
                })

                $.ajax({
                    type : 'POST',
                    url : '/admin/attribute/values',
                    data : JSON.stringify({
                        name : event.target.value
                    }),
                    success : function(response) {
                        valueBox.html(`
                            <option value="" selected>انتخاب کنید</option>
                            ${
                                response.data.map(function (item) {
                                    return `<option value="${item}">${item}</option>`
                                })
                            }
                        `);
                    }
                });
            }

            let createNewAttr = ({ attributes , id }) => {
                return `
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                 <label>عنوان ویژگی</label>
                                 <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select form-control">
                                    <option value="">انتخاب کنید</option>
                                    ${
                                        attributes.map(function(item) {
                                            return `<option value="${item}">${item}</option>`
                                        })
                                    }
                                 </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                 <label>مقدار ویژگی</label>
                                 <select name="attributes[${id}][value]" class="attribute-select form-control">
                                        <option value="">انتخاب کنید</option>
                                 </select>
                            </div>
                        </div>
                         <div class="col-2">
                            <label >اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `
            }

            $('#add_product_attribute').click(function() {
                let attributesSection = $('#attribute_section');
                let id = attributesSection.children().length;

                let attributes = $('#attribute').data('attribute');

                attributesSection.append(
                    createNewAttr({
                        attributes,
                        id
                    })
                );

                $('.attribute-select').select2({ tags : true });
            });
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div id="attribute" data-attribute="{{ json_encode(\App\Models\Attribute::all()->pluck('name')) }}"></div>
                <form action="{{ route('admin.products.store') }}" method="post" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام محصول</label>
                            <input type="text" name="title" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="قیمت را وارد کنید" value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="number" name="inventory" class="form-control" id="inventory" placeholder="موجودی را وارد کنید" value="{{ old('inventory') }}">
                        </div>
                        <div class="form-group">
                            <label for="categories" class="col-sm-2 control-label">دسته بندی ها</label>
                            <select class="form-control" name="categories[]" id="categories" multiple>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <h6>ویژگی محصول</h6>
                        <hr>
                        <div id="attribute_section">

                        </div>
                        <button class="btn btn-sm btn-danger" type="button" id="add_product_attribute">ویژگی جدید</button>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت محصول</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
