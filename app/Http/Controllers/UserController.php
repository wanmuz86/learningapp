<?php

namespace App\Http\Controllers;

use TCG\Voyager\Http\Controllers\VoyagerBreadController as VoyagerBreadController;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class UserController extends VoyagerBreadController {

// POST BR(E)AD
    public function update(Request $request, $id)
    {
        Voyager::canOrFail('edit_users');

  		$slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
        $data->courses()->sync($request->input('courses', []));
        $data->badges()->sync($request->input('badges', []));

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => "Successfully Updated {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    // POST BRE(A)D
    public function store(Request $request)
    {
        Voyager::canOrFail('add_users');

		$slug = $this->getSlug($request);


        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = new $dataType->model_name();
        $this->insertUpdateData($request, $slug, $dataType->addRows, $data);
        
        $data->courses()->sync($request->input('courses', []));
        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => "Successfully Added New {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}