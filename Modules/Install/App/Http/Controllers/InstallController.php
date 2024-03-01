<?php



namespace Modules\Install\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('install::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('install::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param mixed $id
     */
    public function show($id)
    {
        return view('install::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     */
    public function edit($id)
    {
        return view('install::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $id
     */
    public function update(Request $request, $id)
    {
        return view('install::update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     */
    public function destroy($id)
    {
        return view('install::destroy');
    }
}
