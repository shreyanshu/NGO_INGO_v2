<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Donor;

class ProjectController extends Controller
{
    public function index()
 	{
 		$donors= Donor::get();
 		$projects = Project::get();
 		return view('projects', compact('projects', 'donors'));
 	}  

 	public function destroy(Project $project)
 	{
 		$project->donor()->detach();
 		$project->forceDelete();
 		$donors= Donor::get();
 		$projects = Project::get();
 		return view('projects', compact('projects', 'donors'));
 	}

 	public function update(Request $request, Project $project)
 	{
 		Project::where('id', $project->id)
 				->update([
 					'name' => request()->name,
 					'duration' => request()->duration,
 					'budget' => request()->budget,
 					'description'=>request()->description
 					]);

 		$project->donor()->detach();

 		foreach ($request->donors as $donor_id) {
 			$project->donor()->attach($donor_id);
 		}
 			
 		// $donors = Donor::get();
 		// return view('/donors', compact('donors'));
		return redirect('/projects');
 	}

 	public function store(Request $request)
 	{

 		$project = new Project;
 		$project->name = $request->name;
 		$project->duration = $request->duration;
 		$project->budget = $request->budget;
 		$project->description = $request->description;
 		$project->organization_id = 1;
 		$project->sponsor_id = 1;
 		$project->tags= " ";

 		$project->save();


 		foreach ($request->donors as $donor_id) {
 			$project->donor()->attach($donor_id);
 		}

 		return redirect('/projects');

 	}
}

