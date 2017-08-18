<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Donor;
use App\Country;

class DonorController extends Controller
{
    public function index()
 	{
 		$donors = Donor::get();
 		$country = Country::get();

 		return view('donors', compact('donors','country'));
 	}

 	public function destroy(Donor $donor)
 	{
 		$donor->project()->detach();
 		$donor->forceDelete();

 		$donors = Donor::get();
 		$country = Country::get();

 		return view('donors', compact('donors','country'));
 	}  

 	public function update(Donor $donor)
 	{
 		Donor::where('id', $donor->id)
			->update([
				'name' => request()->name, 
				'address'=>request()->address,
				'email'=>request()->email,
				'website'=>request()->website,
				'ph_number'=>request()->phone,
				'description'=>request()->description,
				'estDate'=>request()->estDate,
				'country_id'=>request()->country
			]);
 			
 		// $donors = Donor::get();
 		// return view('/donors', compact('donors'));
		return redirect('/donors');
 	}

 	public function store(Request $request)
 	{
 		$donor = new Donor;
 		$donor->name = $request->name;
 		$donor->address = $request->address;
 		$donor->email = $request->email;
 		$donor->website = $request->website;
 		$donor->ph_number = $request->phone;
 		$donor->description = $request->description;
 		$donor->estDate = $request->estDate;
 		$donor->country_id = $request->country;
 		$donor->logo_id = 1; // needs to be changed
 		$donor->sector_id = 1; // needs ro be changed
 		$donor->district_id = 1; // needs to be changed 
 		$donor->tags = "";

 		$donor->save();

		return redirect('/donors'); 		
 	}
}
