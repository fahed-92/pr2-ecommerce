
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
                                <li class="breadcrumb-item"><a href="{{route('admin.brands')}}">  ألماركات التجارية </a>
                                </li>
                                <li class="breadcrumb-item active">  أضافه ماركة تجارية
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
                                    <h4 class="card-title" id="basic-layout-form"> أضافه ماركة تجارية </h4>
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
                                        <form class="form"
                                              action="{{route('admin.brands.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label> صوره الماركة </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="photo">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('photo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> بيانات الماركة </h4>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            @if(get_languages() -> count() > 0)
                                                                @foreach(get_languages() as $index => $lang)

                                                                    <label for="projectinput1"> اسم الماركة - {{__('messages.'.$lang -> abbr)}} </label>
                                                                    <input type="text" value="" id="name"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="brands[{{$index}}][name]">
                                                                    @error("brands.$index.name")
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
                                                                   name="brands[{{$index}}][abbr]">

                                                            @error("brands.$index.abbr")
                                                            <span class="text-danger"> هذا الحقل مطلوب</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="brands[{{$index}}][is_active]"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   checked/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة  {{__('messages.'.$lang -> abbr)}} </label>

                                                            @error("brands.$index.is_active")
                                                            <span class="text-danger"> </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>




{{--                                            <div class="form-body">--}}

{{--                                                <h4 class="form-section"><i class="ft-home"></i> بيانات الماركة التجارية </h4>--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-md-6">--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <label for="projectinput1"> الاسم--}}
{{--                                                                 </label>--}}
{{--                                                            <input type="text" id="name"--}}
{{--                                                                   class="form-control"--}}
{{--                                                                   placeholder="  "--}}
{{--                                                                   value="{{old('name')}}"--}}
{{--                                                                   name="name">--}}
{{--                                                            @error("name")--}}
{{--                                                            <span class="text-danger">{{$message}}</span>--}}
{{--                                                            @enderror--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-6">--}}
{{--                                                        <div class="form-group mt-1">--}}
{{--                                                            <input type="checkbox" value="1"--}}
{{--                                                                   name="is_active"--}}
{{--                                                                   id="switcheryColor4"--}}
{{--                                                                   class="switchery" data-color="success"--}}
{{--                                                                   checked />--}}
{{--                                                            <label for="switcheryColor4"--}}
{{--                                                                   class="card-title ml-1">الحالة  </label>--}}

{{--                                                            @error("is_active")--}}
{{--                                                            <span class="text-danger">{{$message }}</span>--}}
{{--                                                            @enderror--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                              --}}{{--     <div class="col-md-6">--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <label for="projectinput1"> اسم بالرابط--}}
{{--                                                            </label>--}}
{{--                                                            <input type="text" id="name"--}}
{{--                                                                   class="form-control"--}}
{{--                                                                   placeholder="  "--}}
{{--                                                                   value="{{old('slug')}}"--}}
{{--                                                                   name="slug">--}}
{{--                                                            @error("slug")--}}
{{--                                                            <span class="text-danger">{{$message}}</span>--}}
{{--                                                            @enderror--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    --}}


{{--                                                </div>--}}

{{--                                            </div>--}}


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
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

    @stop