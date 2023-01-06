@include('partials.headercontent');
<section id="searchPagination">
 <div class="container">
  <div class="row">
   <div class="col-md-6">
    <form class="elm-searchboxForm" method="get" action="{{ url('/search') }}">
     <input class="form-control" type="text" placeholder="Search by name, email,subscription" name="keyword">
     <button type="submit" class="searchButton">
     </button>
    </form>
   </div>
   <div class="col-md-6">
    <div class="CustomTabelForm">
     <div class="smdw">
      <select class="custom-select" id="sortbyCustom">
       <option selected>Sort by</option>
       <option value="1">-----</option>
      </select>
     </div>
     <!-- // my pagination -->
    
     <!--<ul id="mydispagination" class="pagination">

     </ul> -->
	  @if(isset($members))
	   {!! $members->links() !!}
      @endif
    </div>
   </div>
  </div>
 </div>
</section>
<section id="searchTable" class="smdw">
 <div class="container">
  <div class="row">
   <div class="col-sm-12">
    <div class="accordion" id="acdShTable">
	 <?php $pos=1 ?>
	 @if(isset($members))
	 @foreach ($members as $member)
     <div class="card row<?php echo $member->id;?>">
      <div class="card-header" id="heading<?php echo $pos; ?>">
       <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $pos; ?>" aria-expanded="false" aria-controls="collapse<?php echo $pos; ?>"> {{ $member->fullName }} </button>
      </div>
      <div id="collapse<?php echo $pos; ?>" class="collapse" aria-labelledby="heading<?php echo $pos; ?>" data-parent="#acdShTable">
       <div class="card-body">
        <div class="table-responsive tableSearchMobil">
         <table class="table table-dark">
          <tbody>
           <tr>
            <th scope="col">Email</th>
            <td>{{ $member->userAppleEmail }}</td>
           </tr>
           <tr>
            <th scope="col">Member since</th>
            <td>@if(!empty($member->member_since)) {{ date('m/d/Y', strtotime($member->member_since)) }} @else N/A @endif </td>
           </tr>
           <tr>
            <th scope="col">Expire</th>
            <td>@if(!empty($member->member_expire)) {{ date('m/d/Y', strtotime($member->member_expire)) }} @else N/A @endif</td>
           </tr>
           <tr>
            <th scope="col">Subscription</th>
            <td class="monthly"><i class="iconCrown">
             </i>@if($member->subscriptionStatus==0) Inactive  @elseif($member->subscriptionStatus==1) Monthly  @else  Yearly  @endif</td>
           </tr>
           <tr>
            <th scope="col">Spent</th>
            <td>${{ $member->spent }}</td>
           </tr>
           <tr>
            <th scope="col">Photos</th>
            <td>{{ $member->photos }}</td>
           </tr>
           <tr>
            <th scope="col">Act.</th>
            <td><a  href="#" type="button" class="subrlink" data-toggle="modal" data-target="#subscriptionModal">
             </a>
             <a href="#" type="button" class="deleteUserlink" data-toggle="modal" data-target="#deleteUserModalmob<?php echo $member->id;?>">
             </a></td>
           </tr>
          </tbody>
         </table>
        </div>
       </div>
      </div>
     </div>
	 <?php $pos++ ?>
	 @endforeach
	 @endif
	 
	  @if(isset($details))
		 @foreach($details as $user)
		   <div class="card row<?php echo $user->id;?>">
		  <div class="card-header" id="heading<?php echo $pos; ?>">
		   <button class="btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $pos; ?>" aria-expanded="false" aria-controls="collapse<?php echo $pos; ?>"> {{ $user->fullName }} </button>
		  </div>
		  <div id="collapse<?php echo $pos; ?>" class="collapse" aria-labelledby="heading<?php echo $pos; ?>" data-parent="#acdShTable">
		   <div class="card-body">
			<div class="table-responsive tableSearchMobil">
			 <table class="table table-dark">
			  <tbody>
			   <tr>
				<th scope="col">Email</th>
				<td>{{ $user->userAppleEmail }}</td>
			   </tr>
			   <tr>
				<th scope="col">Member since</th>
				<td>@if(!empty($member->member_since)) {{ date('m/d/Y', strtotime($member->member_since)) }} @else N/A @endif</td>
			   </tr>
			   <tr>
				<th scope="col">Expire</th>
				<td>@if(!empty($member->member_expire)) {{ date('m/d/Y', strtotime($member->member_expire)) }} @else N/A @endif</td>
			   </tr>
			   <tr>
				<th scope="col">Subscription</th>
				<td class="monthly"><i class="iconCrown">
				 </i>@if($user->subscriptionStatus==0) Inactive  @elseif($user->subscriptionStatus==1) Monthly  @else Yearly  @endif</td>
			   </tr>
			   <tr>
				<th scope="col">Spent</th>
				<td>${{ $user->spent }}</td>
			   </tr>
			   <tr>
				<th scope="col">Photos</th>
				<td>{{ $user->photos }}</td>
			   </tr>
			   <tr>
				<th scope="col">Act.</th>
				<td><a  href="#" type="button" class="subrlink" data-toggle="modal" data-target="#subscriptionModal">
				 </a>
				 <a href="#" type="button" class="deleteUserlink" data-toggle="modal" data-target="#deleteUserModalmob<?php echo $user->id;?>">
				 </a></td>
			   </tr>
			  </tbody>
			 </table>
			</div>
		   </div>
		  </div>
		 </div>
		@endforeach
		 @endif
		@if(!isset($details) && !isset($members))
		<div><p class="errormsg">{{ $message }}</p></div>
	   @endif
    </div>
<div class="dataTables_info">@if(isset($members)) Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }}    	members.
	@endif
	@if(isset($details)) Showing {{ $details->firstItem() }} to {{ $details->lastItem() }} of {{ $details->total() }} members.
	@endif</div>

   </div>
  </div>
 </div>
</section>
<section id="searchTable" class="smup"> 
 <div class="container">
  <div class="row">
   <div class="col-sm-12">
    <div class="table-responsive tableSearch">
	 @if(isset($details))
        <p class="successmsg"> The Search results for your query <b> {{ $query }} </b> are :</p>
	@endif
	
     <table id="stTableSearch" class="apptable table table-dark">
      <thead class="thead-dark">
       <tr class="rowthead-dark">
        <th scope="col" onclick="sortTable(0)" class="sorting">Name</th>
        <th scope="col" onclick="sortTable(1)" class="sorting sorting_asc">Email</th>
        <th scope="col" onclick="sortTable(2)" class="sorting">Member since</th>
        <th scope="col" onclick="sortTable(3)" class="sorting">Expire</th>
        <th scope="col" onclick="sortTable(4)" class="sorting">Subscription</th>
        <th scope="col" onclick="sortTable(5)" class="sorting">Spent</th>
        <th scope="col" onclick="sortTable(6)" class="sorting">Photos</th>
        <th scope="col" ></th>
       </tr>
      </thead>
      <tbody>
	  @if(isset($members))
	  @foreach ($members as $member)
       <tr class="memberrow<?php echo $member->id;?>">
        <td class="nemberName">{{ $member->fullName }}</td>
        <td class="emailId">{{ $member->userAppleEmail }}</td>
        <td class="dateSince">@if(!empty($member->member_since)) {{ date('m/d/Y', strtotime($member->member_since)) }} @else N/A @endif</td>
        <td class="dateExpire">@if(!empty($member->member_expire)) {{ date('m/d/Y', strtotime($member->member_expire)) }} @else N/A @endif</td>
        <td class="monthly"><i class="iconCrown">
         </i>@if($member->subscriptionStatus==0)Inactive  @elseif($member->subscriptionStatus==1) Monthly  @else  Yearly  @endif</td>
        <td class="subscription">${{ $member->spent }}</td>
        <td class="spent">{{ $member->photos }}</td>
        <td class="tabinfo"><div class="dropleft">
          <a href="" class="tabSubLinks bgImg" role="button" id="tabSubLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </a>
          <div class="dropdown-menu" aria-labelledby="tabSubLinks">
           <a href="#" type="button" class="dropdown-item" data-toggle="modal" data-target="#deleteUserModal<?php echo $member->id;?>">
            Delete User
           </a>
           <a class="dropdown-item" href="#">
            Subscription Settings
           </a>
          </div>
         </div></td>
       </tr>
       @endforeach
	   @endif
	   
	   @if(isset($details))
		 @foreach($details as $user)
	    <tr class="memberrow<?php echo $user->id;?>">
		  <td class="nemberName">{{ $user->fullName }}</td>
          <td class="emailId">{{ $user->userAppleEmail }}</td>
          <td class="dateSince">@if(!empty($member->member_since)) {{ date('m/d/Y', strtotime($member->member_since)) }} @else N/A @endif</td>
          <td class="dateExpire">@if(!empty($member->member_expire)) {{ date('m/d/Y', strtotime($member->member_expire)) }} @else N/A @endif</td>
          <td class="monthly"><i class="iconCrown">
          </i>@if($user->subscriptionStatus==0) Inactive  @elseif($user->subscriptionStatus==1) Monthly  @else Yearly  @endif</td>
          <td class="subscription">${{ $user->spent }}</td>
          <td class="spent">{{ $user->photos }}</td>
		  <td class="tabinfo"><div class="dropleft">
          <a href="" class="tabSubLinks bgImg" role="button" id="tabSubLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </a>
          <div class="dropdown-menu" aria-labelledby="tabSubLinks">
           <a href="#" type="button" class="dropdown-item" data-toggle="modal" data-target="#deleteUserModal<?php echo $user->id;?>">
            Delete User
           </a>
           <a class="dropdown-item" href="#">
            Subscription Settings
           </a>
          </div>
         </div></td>
       </tr>
		@endforeach
		 @endif
		@if(!isset($details) && !isset($members))
		<div><p class="errormsg">{{ $message }}</p></div>
	   @endif
      </tbody>
     </table>
    </div>
	
    <div class="dataTables_info">@if(isset($members)) Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} members.
	@endif
	@if(isset($details)) Showing {{ $details->firstItem() }} to {{ $details->lastItem() }} of {{ $details->total() }} members.
	@endif
	</div>
   </div>
  </div>
 </div>
</section>

@if(isset($members))
@foreach ($members as $member)
<div class="modal adminModal fade" id="deleteUserModal<?php echo $member->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-body">
    <p class="modal-title"> This user will be deleted.<br>
     Are you sure?</p>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-danger delete" data-id=<?php echo $member->id; ?>>Delete</button>
   </div>
  </div>
 </div>
</div>
@endforeach
@endif

@if(isset($details))
@foreach ($details as $user)
<div class="modal adminModal fade" id="deleteUserModal<?php echo $user->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-body">
    <p class="modal-title"> This user will be deleted.<br>
     Are you sure?</p>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-danger delete" data-id=<?php echo $user->id; ?>>Delete</button>
   </div>
  </div>
 </div>
</div>
@endforeach
@endif

@if(isset($members))
@foreach ($members as $member)
<div class="modal adminModal fade" id="deleteUserModalmob<?php echo $member->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-body">
    <p class="modal-title"> This user will be deleted.<br>
     Are you sure?</p>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-danger deletemob" data-id=<?php echo $member->id; ?>>Delete</button>
   </div>
  </div>
 </div>
</div>
@endforeach
@endif

@if(isset($details))
@foreach ($details as $user)
<div class="modal adminModal fade" id="deleteUserModalmob<?php echo $user->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-body">
    <p class="modal-title"> This user will be deleted.<br>
     Are you sure?</p>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-danger deletemob" data-id=<?php echo $user->id; ?>>Delete</button>
   </div>
  </div>
 </div>
</div>
@endforeach
@endif
@include('partials.footercontent');