<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    /**
     * Mostrar términos y condiciones
     */
    public function terms(): View
    {
        return view('legal.terms');
    }

    /**
     * Mostrar política de privacidad
     */
    public function privacy(): View
    {
        return view('legal.privacy');
    }

    /**
     * Mostrar política de protección de datos
     */
    public function dataProtection(): View
    {
        return view('legal.data-protection');
    }
}
