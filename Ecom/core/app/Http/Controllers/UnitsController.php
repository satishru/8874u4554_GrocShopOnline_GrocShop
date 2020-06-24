<?php

namespace GroceryApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use GroceryApp\Models\Units;


class UnitsController extends Controller
{
    protected $redirectTo = 'unit';

    protected $VIEW  = 'units.view_unit';
    protected $ADD   = 'units.add_unit';
    protected $EDIT  = 'units.edit_unit';

    public function adminPanel() {
        return $this->adminPanelPath($this->redirectTo);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Units::all();
        return view($this->VIEW, compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = new Units;
        $action = route('unit.store');
        $method = "POST";
        $submit_text = "SUBMIT";

        return view($this->ADD, compact('unit', 'action', 'method', 'submit_text'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'formError');
        }

        Units::create([
            'unit_name' => $request->unit_name,        
            'added_by' => $this->getUserId(),
            'added_ip' => $this->getIp()
        ]);
        return redirect($this->adminPanel())->withAlert($this->getSuccess());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Units::find($id);
        $action = route('unit.update', $unit->unit_id);
        $method = "PUT";
        $submit_text = "UPDATE";

        return view($this->EDIT, compact('unit', 'action', 'method', 'submit_text'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator, 'formError');
        }
        $request['added_by'] = $this->getUserId();
        $request['added_ip'] = $this->getIp();

        Units::find($id)->update($request->all());
        return redirect($this->adminPanel())->withAlert($this->getUpdate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $request = new Request;
        $unit = Units::find($id);
        $request['is_active'] = $this->getStatus($unit->is_active);
        Units::find($id)->update($request->all());
        return redirect($this->adminPanel())->withAlert($this->getUpdate());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Units::destroy($id);
        //return redirect($this->redirectTo)->withAlert($this->getDelete());
        return redirect($this->adminPanel());
    }

    public function getValidationRules()
    {
        return [
            'unit_name' => 'required|string|max:50'
        ];
    }
}
