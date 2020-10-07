<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class outputController extends Controller
{
    public function add()
    {
        return view('admin.output.create');
    }

    public function create()
    {
        return redirect('admin/outputcreate');
    }

    public function edit()
    {
        return view('admin.output.edit');
    }

    public function update()
    {
        return redirect('admin/output/edit');
    }

    
    
}

