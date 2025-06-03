<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{


    public function add_general(Request $request)
    {
        // معالجة الملفات المرفوعة
        if ($request->has('general_file')) {
            foreach ($request->file('general_file', []) as $name => $file) {
                if ($file && $file->isValid()) {
                    $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('general', $filename, 'public');
                    GeneralInfo::setValue($name, $path);
                }
            }
        }

        // معالجة القيم النصية
        if ($request->has('general')) {
            $general = $request->input('general');

            // تأكد من أن خيار واحد فقط مفعل
            if (!empty($general['custom_payment_enabled'])) {
                $general['custom_payment_enabled'] = '1';
                $general['multiple_payments_enabled'] = '0';
            } elseif (!empty($general['multiple_payments_enabled'])) {
                $general['multiple_payments_enabled'] = '1';
                $general['custom_payment_enabled'] = '0';
            } else {
                $general['custom_payment_enabled'] = '0';
                $general['multiple_payments_enabled'] = '0';
            }

            foreach ($general as $name => $value) {
                GeneralInfo::setValue($name, $value);
            }
        }


        // معالجة الدفعات المتعددة
        if ($request->filled('multiple_payments') && $request->input('general.multiple_payments_enabled')) {
            $validPayments = array_filter($request->input('multiple_payments', []), function ($payment) {
                return !empty(trim($payment));
            });
            GeneralInfo::setValue('multiple_payments', json_encode(array_values($validPayments)));
        } else {
            GeneralInfo::setValue('multiple_payments', null);
        }

        return redirect()->back()->with(['success' => trans('تم التعديل بنجاح')]);
    }
    public function upload_file(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads/temp', 'public'); // Save to public disk
            $url = Storage::disk('public')->url($path);
            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
