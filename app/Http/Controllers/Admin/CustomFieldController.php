<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomFieldRequest;
use App\Models\Custom_field;
use App\Models\Custom_field_value;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomFieldController extends Controller
{
    public function index()
    {
        $default_lang = get_default_lang();
        $customFields = Custom_field::where('translation_lang', $default_lang)
            ->selection()
            ->get();
        return view('admin.custom_field.index', compact('customFields'));
    }

    public function create()
    {
        return view('admin.custom_field.create');
    }

    public function store(Request $request)
    {
//        return $request;
        try {
//            try {

                $customFields = collect($request->customField);

                $filter = $customFields->filter(function ($value, $key) {
                    return $value['abbr'] == get_default_lang();
                });

                $default_field = array_values($filter->all()) [0];

                DB::beginTransaction();

                $default_field_id = Custom_field::insertGetId([
                    'translation_lang' => $default_field['abbr'],
                    'translation_of' => 0,
                    'name' => $default_field['name'],
                    'active' => $default_field['active'],
                ]);

                $fields = $customFields->filter(function ($value, $key) {
                    return $value['abbr'] != get_default_lang();
                });


                if (isset($fields) && $fields->count()) {

                    $fields_arr = [];
                    foreach ($fields as $field) {
                        $fields_arr[] = [
                            'translation_lang' => $field['abbr'],
                            'translation_of' => $default_field_id,
                            'name' => $field['name'],
                            'active' => $field['active'],
                        ];
                    }

                    Custom_field::insert($fields_arr);
                }

                DB::commit();

                return redirect()->route('admin.customfield')->with(['success' => 'تم الحفظ بنجاح']);

            } catch (\Exception $ex) {
                DB::rollback();
//return $ex->getMessage();
                return redirect()->route('admin.customfield')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
    }

    public function edit($id)
    {
        $customField = Custom_field::find($id);

        if (!$customField)
            return redirect()->route('admin.customfield')->with(['error' => 'هذا الحقل غير موجود ']);

        return view('admin.custom_field.edit', compact('customField'));
    }


//        $customField = Custom_field::select()->find($id);
//        if (!$customField) {
//            return redirect()->route('admin.customfield')->with(['error' => 'هذه اللغة غير موجوده']);
//        }
//
//        return view('admin.custom_field.edit', compact('customField'));
//    }

    public function update($id, CustomFieldRequest $request)
    {
//return $request;

        try {
            $customField = Custom_field::find($id);

            if (!$customField)
                return redirect()->route('admin.customfield')->with(['error' => 'هذا القسم غير موجود ']);

            // update date

             $field = array_values($request->CustomField) [0];

            if (!$request->has('customField.0.active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);


            $customField->update([
                    'name' => $field['name'],
                    'active' => $request->active,
                ]);
            return redirect()->route('admin.customfield')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.customfield')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function destroy($id)
    {

        try {
            $customField = Custom_field::find($id);
            if (!$customField) {
                return redirect()->route('admin.customfield', $id)->with(['error' => 'هذه اللغة غير موجوده']);
            }
            $customField->delete();

            return redirect()->route('admin.customfield')->with(['success' => 'تم حذف اللغة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.customfield')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
    }
    public function changeStatus($id)
    {
        try {
            $customField = Custom_field::find($id);
            if (!$customField)
                return redirect()->route('admin.customfield')->with(['error' => 'هذا القسم غير موجود ']);

            $status =  $customField -> active  == 0 ? 1 : 0;

            $customField -> update(['active' =>$status ]);

            return redirect()->route('admin.customfield')->with(['success' => ' تم تغيير الحالة بنجاح ']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.customfield')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
    public function customFieldValues($id){
        $customField = Custom_field::find($id);
        $values=$customField ->values()->get();

        if (!$customField)
            return redirect()->route('admin.customfield')->with(['error' => 'هذا الحقل غير موجود ']);

        return view('admin.custom_field.values', compact(['values','customField']));
    }

    public function create_value($id){
        $customField = Custom_field::find($id);
        $values=$customField ->values()->get();

        if (!$customField)
            return redirect()->route('admin.customfield')->with(['error' => 'هذا الحقل غير موجود ']);

        return view('admin.custom_field.create_values', compact('values','customField'));
    }

    public function store_value(Request $request,$id){
          try {
              $customField = Custom_field::find($id);
              $CId=$customField->id;
            $values = collect($request->values);

            $filter = $values->filter(function ($value, $key) {
                return $value['abbr'] == get_default_lang();
            });

            $default_value = array_values($filter->all()) [0];

            DB::beginTransaction();

            $default_field_id = Custom_field_value::insertGetId([
                'translation_lang' => $default_value['abbr'],
                'translation_of' => 0,
                'custom_field_id' => $CId,
                'name' => $default_value['name'],
                'active' => $default_value['active'],
            ]);

            $fields_value = $values->filter(function ($value, $key) {
                return $value['abbr'] != get_default_lang();
            });


            if (isset($fields) && $fields->count()) {

                $fields_arr = [];
                foreach ($fields_value as $field_value) {
                    $fields_arr[] = [
                        'translation_lang' => $field_value['abbr'],
                        'translation_of' => $default_field_id,
                        'custom_field_id' => $CId,
                        'name' => $field_value['name'],
                        'active' => $field_value['active'],
                    ];
                }

                Custom_field_value::insert($fields_arr);
            }

            DB::commit();

            return redirect()->route('admin.fieldvalues.values',$CId)->with(['success' => 'تم الحفظ بنجاح']);

        } catch (\Exception $ex) {
            DB::rollback();
//return $ex->getMessage();
            return redirect()->route('admin.customfield')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
