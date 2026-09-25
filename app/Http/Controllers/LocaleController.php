<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch application language between English and Arabic.
     */
    public function switch(Request $request, string $locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}
