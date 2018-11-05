<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Libraries\Custom;

class ExploreController extends Controller
{
    protected $custom;
    
    public function __construct()
    {
    	$this->custom = new Custom();
    }

    public function add_country(Request $request)
    {
        $name = $request->name;
        $time = date('Y-m-d H:i:s');

        if (empty($name))
        {
            $resp = [
                'status' => 0,
                'message' => 'Country name is required'
            ];
            return response()->json($resp);
        }

        $country_exists = DB::table('countries')
            ->where('name', $name)
            ->where('deleted', 0)
            ->first();

        if (!empty($country_exists))
        {
            $resp = [
                'status' => 0,
                'message' => 'Country already exists'
            ];
            return response()->json($resp);
        }

        $data = [
            'name' => $name, 'created_at' => $time
        ];

        $country_ins = DB::table('countries')
            ->insert($data);

        $resp = [
            'status' => 1,
            'message' => 'Country saved'
        ];
        return response()->json($resp);
    }

    public function add_city(Request $request)
    {
        $name = $request->name;
        $state_id = $request->state_id;
        $time = date('Y-m-d H:i:s');

        if (empty($name) || empty($state_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'All fields are required'
            ];
            return response()->json($resp);
        }

        if (!is_int($state_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'Please enter a valid State id'
            ];
            return response()->json($resp);
        }

        $state_exists = DB::table('states')
            ->where('id', $state_id)
            ->where('deleted', 0)
            ->first();

        if (empty($state_exists))
        {
            $resp = [
                'status' => 0,
                'message' => 'State not found'
            ];
            return response()->json($resp);
        }

        $city_exists = DB::table('cities')
            ->where('name', $name)
            ->where('state_id', $state_id)
            ->where('deleted', 0)
            ->first();

        if (!empty($city_exists))
        {
            $resp = [
                'status' => 0,
                'message' => 'This City has already been added'
            ];
            return response()->json($resp);
        }

        $data = [
            'name' => $name, 'state_id' => $state_id, 'created_at' => $time
        ];

        $cities_ins = DB::table('cities')
            ->insert($data);

        $resp = [
            'status' => 1,
            'message' => 'City saved'
        ];
        return response()->json($resp);
    }

    public function add_state(Request $request)
    {
        $name = $request->name;
        $country_id = $request->country_id;
        $time = date('Y-m-d H:i:s');

        if (empty($name) || empty($country_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'All fields are required'
            ];
            return response()->json($resp);
        }

        if (!is_int($country_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'Please enter a valid country id'
            ];
            return response()->json($resp);
        }

        $country_exists = DB::table('countries')
            ->where('id', $country_id)
            ->where('deleted', 0)
            ->first();

        if (empty($country_exists))
        {
            $resp = [
                'status' => 0,
                'message' => 'Country not found'
            ];
            return response()->json($resp);
        }

        $state_exists = DB::table('states')
            ->where('name', $name)
            ->where('country_id', $country_id)
            ->where('deleted', 0)
            ->first();

        if (!empty($state_exists))
        {
            $resp = [
                'status' => 0,
                'message' => 'This State has already been added'
            ];
            return response()->json($resp);
        }

        $data = [
            'name' => $name, 'country_id' => $country_id, 'created_at' => $time
        ];

        $state_ins = DB::table('states')
            ->insert($data);

        $resp = [
            'status' => 1,
            'message' => 'State saved'
        ];
        return response()->json($resp);
    }

    public function show_cities_by_country(Request $request)
    {
        $country = $request->country;
        $result = [];

        if (empty($country))
        {
            $resp = [
                'status' => 0,
                'message' => 'Please enter a Country'
            ];
            return response()->json($resp);
        }

        $country_id = DB::table('countries')
            ->where('name', $country)
            ->where('deleted', 0)
            ->value('id');

        if (empty($country_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'Country not found'
            ];
            return response()->json($resp);
        }

        $states = DB::table('states')
            ->where('country_id', $country_id)
            ->where('deleted', 0)
            ->get(['id', 'name', 'country_id']);

        foreach ($states as $state)
        {
            $cities = DB::table('cities')
                ->where('state_id', $state->id)
                ->where('deleted', 0)
                ->get(['id', 'name', 'state_id']);

            foreach ($cities as $city)
            {
                $data = (object) ['id' => $city->id, 'name' => $city->name, 'state' => $state->name];
                array_push($result, $data);
            }
        }

        $resp = [
            'status' => 1,
            'cities' => $result
        ];
        return response()->json($resp);
    }

    public function show_countries()
    {
        $countries = DB::table('countries')
            ->where('deleted', 0)
            ->get(['id', 'name']);

        $resp = [
            'status' => 1,
            'countries' => $countries
        ];
        return response()->json($resp);
    }

    public function show_states(Request $request)
    {
        $country_id = $request->country_id;

        if (empty($country_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'Country Id is required'
            ];
            return response()->json($resp);
        }

        if (!is_int($country_id))
        {
            $resp = [
                'status' => 0,
                'message' => 'Please enter a valid country id'
            ];
            return response()->json($resp);
        }

        $states = DB::table('states')
            ->where('country_id', $country_id)
            ->where('deleted', 0)
            ->get(['id', 'name', 'country_id']);

        $resp = [
            'status' => 1,
            'states' => $states
        ];
        return response()->json($resp);
    }

}
