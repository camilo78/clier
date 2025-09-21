<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $companyInfo = CompanyInfo::first();

        return view('contact', compact('companyInfo'));
    }
}