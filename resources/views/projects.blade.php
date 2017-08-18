@extends('layouts.layout')

@section('title')
	Projects
@endsection

@section('content')

	<button type = "button" class="btn btn-danger" data-toggle="modal" data-target="#newModal" data-act="new">
		<img src="/images/glyphicons-191-plus-sign.png">   NEW</button>

	<a href = "/" class="btn btn-primary offset-sm-9">
			<img src="/images/glyphicons-21-home.png"></span>   HOME</a>

	<br><br>
	<!-- <div class="container"> -->
		<table id="datatable" class="table" width = "100%">
		  <thead>
		    <tr>
		      <th>Name</th>
		      <th>Duration</th>
		      <th>Budget</th>
		      <th>Organization</th>
		      <th>Start Date</th>
		      <th>View</th>
		      <th>Edit</th>
		      <th>Delete</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($projects as $project)
			    <tr>
			      <td>{{$project->name}}</td>
			      <td>{{$project->duration}}</td>
			      <td>{{$project->budget}}</td>
			      <td>{{$project->organization->name}}</td>
			      <td>{{$project->created_at}}</td>

			      <?php
				      $doIds = "";
				      foreach($project->donor()->get() as $do){
				      	$doIds = $doIds.".".$do['id'];
				      }
				     
			      ?>
			      
			      <td><img src="/images/glyphicons-52-eye-open.png" data-toggle="modal" data-target="#newModal" data-whatever="{{ $project }}" data-donors = "{{ $doIds }}" data-act="view"></td>
			      <td><img src="/images/glyphicons-31-pencil.png" data-toggle="modal" data-target="#newModal" data-whatever="{{ $project }}" data-donors = "{{ $doIds }}" data-act="edit"></td>
			      <td><a href="/projects/delete/{{ $project->id }}"><img src="/images/glyphicons-193-remove-sign.png"></a></td>
			  		    	
			    </tr>
		    @endforeach 
		  </tbody>
		</table>
	<!-- </div> -->
	<div id = "newModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class = "modal-content">
				<div class="modal-header"><h3 id = "header"></h3></div>
				<div class="modal-body">
					<form class = "form-horizontal" role = "form" method="POST" action="/" id = "form_popup">
						 	
						 	<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class = "form-group">
								<label for = "name" class = "control-label col-sm-1">Name: </label>
								<div class = "col-sm-12">
								   <input type = "text" class = "form-control" name="name" placeholder = "Enter Project Name" required>
								</div>
							</div>	
						

							<div class = "form-group">
								<label for = "duration" class = "control-label col-sm-1">Duration: </label>
								<div class = "col-sm-12">
								   <input type = "text" class = "form-control" name = "duration" placeholder = "Enter duration in years" required>
								</div>
							</div>

							<div class = "form-group">
								<label for = "budget" class = "control-label col-sm-1">Budget: </label>
								<div class = "col-sm-12">
								   <input type = "number" class = "form-control" name = "budget" placeholder = "Enter budget in NPR" required>
								</div>
							</div>

							<!-- <div class = "form-group">
								<label for = "website" class = "control-label col-sm-1">Website: </label>
								<div class = "col-sm-12">
								   <input type = "text" class = "form-control" name = "website" placeholder = "Website" required>
								</div>
							</div> -->

							<!-- <div class = "form-group">
								<label for = "budget" class = "control-label col-sm-1">Donors: </label>
								<div class = "col-sm-12">
								   <input type = "text" class = "form-control" name = "Donors" placeholder = "Enter budget in NPR" required>
								</div>
							</div> -->

							<!-- <div class = "form-group">
								<label for = "donor" class = "control-label col-sm-1">Donor: </label>
								<div class = "col-sm-12">
								   <select class="form-control" name="donor" id="donor" multiple="multiple">
										@foreach($donors as $donor)
											<option value='{{ $donor->id }}'>{{ $donor->name }}</option>
										@endforeach
									</select>
								</div>
							</div> -->

							<div class = "form-group">   
						        <label for = "donor" class = "control-label col-sm-1" >Donor: </label>
						           <div class = "col-sm-12">
						              <select class="form-control" name= "donors[]" id="donors" multiple="multiple" class="donors">
						                @foreach($donors as $donor)
											<option value="{{ $donor->id }}">{{ $donor->name }}</option>
										@endforeach
						        	  </select>
						           </div>   
							  </div>

							<div class = "form-group">
								<label for = "description" class = "control-label col-sm-1">Description: </label>
								<div class = "col-sm-12">
								   <textarea class = "form-control" name = "description" placeholder = "Short Description" required></textarea>
								</div>
							</div>
						</div>

							
				</div>
				<div class="modal-footer">
					
	        		<button type="submit" class="btn btn-primary" id="save">Save</button>
	        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      		</div>
	      		</form>	
			</div>
		</div>
	</div>
	 <script type="text/javascript">
		$(document).ready(function(){  
    		$('#datatable').DataTable();  
    		$('#donors').select2({ width: '100%' });
 		});
 		$('#newModal').on('show.bs.modal', function (event) 
 		{
			var button = $(event.relatedTarget) // Button that triggered the modal
			
			if(button.data('act') == "view" || button.data('act')=="edit")
			{
				 // Extract info from data-* attributes
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
				var data = button.data('whatever')
				var donors = button.data('donors')
				document.write(donors)
				modal.find('.modal-body input[name="name"]').val(data['name'])
				modal.find('.modal-body input[name="duration"]').val(data['duration'])
				modal.find('.modal-body input[name="budget"]').val(data['budget'])
				// modal.find('.modal-body input[name="website"]').val(data['website'])
				modal.find('.modal-body textarea[name="description"]').val(data['description'])
				// modal.find('.modal-body select[name="donors[]"]').select2('val':['3'])
				// var PRESELECTED_FRUITS = [ '7','3','4']
				$('#donors').select2('val', ["7", "3", "4"])
				
				if(button.data('act') == "view")
				{
					var form = document.getElementById("form_popup");
					var elements = form.elements;
					for (var i = 0, len = elements.length; i < len; ++i) 
					{
					    elements[i].readOnly = true;
					}
					document.getElementById("save").style.visibility="hidden";
					$('#donors').select2("enable", false);
					$("h3").text("View donor");
					
					// document.getElementById("save_changes").style.visibility="hidden";
				}

				if(button.data('act') == "edit")
				{	
					var form = document.getElementById("form_popup");
					var elements = form.elements;
					for (var i = 0, len = elements.length; i < len; ++i) 
					{
					    elements[i].readOnly = false;
					}
					// document.getElementById("save_changes").style.visibility="visible";
					document.getElementById("save").style.visibility="visible";
					form.action = "/project/update/" + data['id'];
					$('#donors').select2("enable");
					$("h3").text("Edit donor");
					// var link = "/donor/update/" + data['id'];
					// document.getElementById("save").onClick("location.href='"+link+"'");
				}
			}

			else if(button.data('act') == "new")
			{
				var form = document.getElementById("form_popup");
				var elements = form.elements;

				for (var i = 0, len = elements.length; i < len; ++i) 
				{
					elements[i].readOnly = false;
				    if(elements[i].name != "_token")
				    {
				    	elements[i].value = null;
				    }
				}
				// document.getElementById("save_changes").style.visibility="hidden";
				document.getElementById("save").style.visibility="visible";
				form.action="/project/create";
				$('#donors').select2("enable");
				$("h3").text("Add project");
			}
		})
	 </script>

@endsection