<?php

class RequestController extends BaseController
{

    public function ShowRequest()
    {
        return View::make('pages.message', [ 'title' => 'test', 'message' => 'Request' ]);
    }

    public function ShowCreate()
    {
        return View::make('pages.request.create');
    }

    public function ShowPurchase()
    {
        return View::make('pages.request.purchase');
    }

    public function DoCreate()
    {
        $requestData = Input::all();

        $validationRules = array(
            'name' => 'required',
            'location' => 'required',
            'skills' => 'required',
            );

        $validator = Validator::make($requestData, $validationRules);

        if($validator->fails())
        {
            return Redirect::action('RequestController@ShowCreate')->withErrors($validator);
        }

        else
        {
            $request = new Requests;
            $request->name = Input::get('name');
            $request->request_location = Input::get('location');
            $request->service_category = "General";
            $request->skills_required = Input::get('skills');
            $request->creator_user_id = 1;
            $request->save();

            return Redirect::action('RequestController@ShowCreate')->with('message', 'Request submitted to database!');
        }
    }
}