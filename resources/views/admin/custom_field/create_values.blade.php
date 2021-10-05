@extends('layouts.admin')

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href=""> الحقةل الخاصة </a>
                                </li>
                                <li class="breadcrumb-item active">إضافة حقل خلص
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> إضافة حقل خاص </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{route('admin.customfield.store_value',$customField->id)}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                {{--                                                <label> صوره القسم </label>--}}
                                                {{--                                                <label id="projectinput7" class="file center-block">--}}
                                                {{--                                                    <input type="file" id="file" name="photo">--}}
                                                {{--                                                    <span class="file-custom"></span>--}}
                                                {{--                                                </label>--}}
                                                {{--                                                <span class="text-danger"> </span>--}}
                                                {{--                                            </div>--}}


                                                <div class="form-body">
                                                    <h4 class="form-section"><i class="ft-home"></i> بيانات قيمة الحقل الخاص </h4>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                @if(get_languages() -> count() > 0)
                                                                    @foreach(get_languages() as $index => $lang)

                                                                        <label for="projectinput1"> اسم قيمة الحقل الخاص - {{__('messages.'.$lang -> abbr)}} </label>
                                                                        <input type="text" value="" id="name"
                                                                               class="form-control"
                                                                               placeholder="  "
                                                                               name="values[{{$index}}][name]">
                                                                        @error("values.$index.name")
                                                                        <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                        @enderror
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 hidden">
                                                            <div class="form-group">
                                                                <label for="projectinput1"> أختصار اللغة {{__('messages.'.$lang -> abbr)}} </label>
                                                                <input type="text" id="abbr"
                                                                       class="form-control"
                                                                       placeholder="  "
                                                                       value="{{$lang -> abbr}}"
                                                                       name="values[{{$index}}][abbr]">

                                                                @error("values.$index.abbr")
                                                                <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mt-1">
                                                                <input type="checkbox" value="1"
                                                                       name="values[{{$index}}][active]"
                                                                       id="switcheryColor4"
                                                                       class="switchery" data-color="success"
                                                                       checked/>
                                                                <label for="switcheryColor4"
                                                                       class="card-title ml-1">الحالة  {{__('messages.'.$lang -> abbr)}} </label>

                                                                @error("values.$index.active")
                                                                <span class="text-danger"> </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                                {{--                                                <div class="row">--}}

                                                {{--                                                    <div class="col-md-6">--}}
                                                {{--                                                        <div class="form-group">--}}
                                                {{--                                                            <label for="projectinput2"> الاتجاة </label>--}}
                                                {{--                                                            <select name="direction" class="select2 form-control">--}}
                                                {{--                                                                <optgroup label="من فضلك أختر اتجاه اللغة ">--}}
                                                {{--                                                                    <option value="rtl">من اليمين الي اليسار</option>--}}
                                                {{--                                                                    <option value="ltr">من اليسار الي اليمين</option>--}}
                                                {{--                                                                </optgroup>--}}
                                                {{--                                                            </select>--}}
                                                {{--                                                            <span class="text-danger"></span>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i> تراجع
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> حفظ
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection