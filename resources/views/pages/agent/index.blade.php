@extends('layouts.simple.master')
@section('title', 'Basic DataTables')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/photoswipe.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Basic DataTables</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Data Tables</li>
<li class="breadcrumb-item active">Basic DataTables</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>Data Agent</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="display" id="basic-1">
							<thead>
								<tr class="text-center">
                                    <th style="width: 10px">No.</th>
                                    <th>Nama Agent</th>
                                    <th>Sort</th>
                                    <th>Project</th>
                                    <th>Closing Amount</th>
                                    <th>Active</th>
                                    <th>Action</th>
								</tr>
							</thead>
                            <tbody>
							@forelse ($data as $agent)
								<tr class="text-center">
									<td>{{$loop->iteration}}</td>
									<td class="text-start">
										<div class="avatar clearfix">
											<img class="img-50 rounded-circle img-thumbnail" src="../assets/images/user/1.jpg" alt="#">
											{{-- <div class="status-circle online"></div> --}}
											<strong>{{$agent->nama_agent}}</strong>
										</div>  
									</td>
									<td>{{$agent->urut_agent}}</td>
									<td>{{$agent->nama_project}}</td>
									<td>
										@if ($agent->closing_amount > 0)
										<span style="color:#51bb25">Rp. {{number_format($agent->closing_amount,0, ',' , '.')}}</span>
										@else
										<span style="color:#f73164">Rp. {{number_format($agent->closing_amount,0, ',' , '.')}}</span>
										@endif
										
									</td>
									<td>
										@if (!$agent->active)
										<form action="{{route('agent.active')}}" method="POST" onsubmit="return confirm('Non aktifkan Agent {{$agent->nama_agent}} ?')">
											@method('post')
											@csrf
											<input type="hidden" value="{{$agent->id}}" name="agent_id">
											<button class="btn" type="submit">
												<span class="badge rounded-pill round-badge-info">Active</span>
											</button>
										</form>
										@else
										<form action="{{route('agent.nonactive')}}" method="POST" onsubmit="return confirm('Aktifkan Agent {{$agent->nama_agent}} ?')">
											@method('post')
											@csrf
											<input type="hidden" value="{{$agent->id}}" name="agent_id">
											<button class="btn" type="submit">
												<span class="badge rounded-pill round-badge-secondary">Non Active</span>
											</button>
										</form>
										@endif
									</td>
									<td>
										<a title="Show Detail" data-bs-toggle="modal" data-bs-target="#detail{{$agent->id}}"><img src="{{asset('assets/images/button/info.png')}}" alt="info"></a>
										<a title="Sales" class="ms-1" href="{{route('sales.index', $agent->id)}}"><img src="{{asset('assets/images/button/users.png')}}" alt="Sales"></a>
										<a title="Delete Agent" class="ms-1" href=""><img src="{{asset('assets/images/button/trash.png')}}" alt="Delete Agent"></a>
									</td>
								</tr>

								<div class="modal fade" id="detail{{$agent->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
									   <div class="modal-content"  style="border-radius: 20px;">
										  <div class="modal-header" style="background-color: #6F9CD3; border-top-left-radius: 20px;border-top-right-radius: 20px;">
											<h2 class="modal-title text-white" style="font-family: Montserrat ,
											sans-serif Medium 500; font-size: 25px;"><strong>MAKUTA</strong> Pro</h2>
											 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
										  </div>
										  <form action='' method="POST" enctype="multipart/form-data">
											@csrf
											<div class="modal-body form">
												<div class="row">
													<div class="user-profile">
														<div class="card hovercard text-center">
															<div class="user-image" style="margin-top: 80px">
																<div class="avatar"><img alt="photo" src="{{asset('assets/images/avtar/user.jpg')}}" id="photoPreview"></div>
																<div class="icon-wrapper" id="changePhoto"><i class="icofont icofont-pencil-alt-5"></i></div>
																<input type="file" id="photo" style="display:none;" accept="image/*" onchange="loadFile(event)"/>
															</div>
														</div>
													</div>
													<h6 class="text-center mb-0">{{$agent->pic}}</h6>
													<p class="text-center mb-3" style="color: #827575">{{$agent->nama_agent}}</p>
												</div>
												<div class="row mb-2">
													<div class="col-lg-6">
														<label style="color: #827575">Join Date</label>
														<input class="form-control mb-2" style="border-radius: 11px;color:#645d5d" type="text" value="{{date_format(date_create($agent->created_at), "d F Y")}}" disabled>
													</div>
													<div class="col-lg-6">
														<label  style="color: #827575">Username</label>
														<input class="form-control mb-2" style="border-radius: 11px;color:#645d5d" type="text" value="{{$agent->username}}" name="username" disabled>
													</div>
												</div>
												<div class="row mb-2">
													<div class="col-lg-6">
														<label  style="color: #827575">No. Handphone</label>
														<input class="form-control mb-2" style="border-radius: 11px;color:#645d5d" type="text" value="{{$agent->hp}}" name="hp">
													</div>
													<div class="col-lg-6">
														<label  style="color: #827575">Email</label>
														<input class="form-control mb-2" style="border-radius: 11px;color:#645d5d" type="email" value="{{$agent->email}}" name="email" >
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<label  style="color: #827575">Change Password</label>
														<input class="form-control mb-2" style="border-radius: 11px;color:#645d5d" type="password" value="" name="password">
													</div>
												</div>
											</div>
										  <div class="modal-footer">
											<button class="btn  modal-close " style="background-color: #6F9CD3; border-radius: 50px; color: #fff;" type="submit">Save Change</button>
										  </div>
										  </form>
									   </div>
									</div>
								</div>
							@empty
								
							@endforelse
                            </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



 
@endsection

@section('script')
<script>
	$('#changePhoto').click(function() {
		$('#photo').click();
	});

	var loadFile = function(event) {
		var output = document.getElementById('photoPreview');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
		URL.revokeObjectURL(output.src) // free memory
		}
	};
</script>
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
<script src="{{asset('assets/js/photoswipe/photoswipe.min.js')}}"></script>
<script src="{{asset('assets/js/photoswipe/photoswipe-ui-default.min.js')}}"></script>
<script src="{{asset('assets/js/photoswipe/photoswipe.js')}}"></script>

@endsection