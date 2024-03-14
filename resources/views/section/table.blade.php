<div class="container-fluid" style="margin-top: 15px;">
    <div class='row'>
        <div class='col-sm-5'>
            <div class='box box-solid box-default'>
                <div class='box-header bg-navy-active'>
                    <h5 class="box-title">New Section</h5>
                </div>
                <div class='box-body'>
                    <form class="form" method="post" action="" id="resource-form">
                        {{csrf_field()}}
                        <div class='form-group'>
                            <label>Add New Section</label>
                            <input type="text" name="program_code" class="form-control">
                        </div>
                        <div class='form-group'>
                            <label>Level</label>
                            <select name="level" class="form-control select2">
                                <option value="">Select Year Level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <button type='submit' class='btn btn-flat btn-success btn-block'>Save and Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class='col-sm-7'>
            <div class="box box-default">
                <div class="box-header">
                    <h5 class="box-title">List of Created Sections</h5>
                    {{-- <div class="box-tools pull-right">
                        <a href="{{url('/admin/section_management/archive')}}" class="btn btn-flat btn-danger"><i class="fa fa-warning"></i> Archive Section</a>
                    </div> --}}
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width='20%'>Section Name</th>
                                    <th width='20%'>Level</th>
                                    {{-- <th width='20%'>Section Name</th>
                                    <th width='20%'>Status</th> --}}
                                    <th width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if(!$sections->isEmpty())
                                @foreach($sections as $section) --}}
                                <tr>
                                    <td>BSCS</td>
                                    <td>1</td>
                                    {{-- <td>BSCS</td> --}}
                                    {{-- <td>
                                        @if($section->is_active == 1)
                                        <label class='label label-success'>Active</label>
                                        @else
                                        <label class='label label-danger'>Inactive</label>
                                        @endif
                                    </td> --}}
                                    <td>
                                        {{-- <button data-toggle="modal" data-target="#myModal" onclick="editsection('{{$section->id}}')" title="Edit Record" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></button>
                                        <a href="{{url('/admin/section_management/archive',array($section->id))}}" class="btn btn-flat btn-danger" title="Change to Inactive Status?" onclick="confirm('Do you wish to archive the Record?')"><i class="fa fa-times"></i></a> --}}
                                        <button data-toggle="modal" data-target="#myModal" onclick="editsection('')" title="Edit Record" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></button>
                                        <a href="{{url('/admin/section_management/archive',array())}}" class="btn btn-flat btn-danger" title="Change to Inactive Status?" onclick="confirm('Do you wish to archive the Record?')"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                {{-- @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="myModal" class="modal fade" role="dialog">
    <div id='displayedit'>
    </div>
</div>

@section('footer-script')
<script src='{{asset('plugins/select2/select2.js')}}'></script>
<script>
$('#program_code').on('change',function(){
    if(this.value!='Please Select'){
        $('#section_name').val(this.value+'-');
    }else{
        $('#section_name').val(' ');
    }
})    
    
function editsection(section_id){
    var array = {};
    array['section_id'] = section_id;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/section_management/edit_section",
        data: array,
        success: function(data){
            $('#displayedit').html(data).fadeIn();
            $('#myModal').modal('show');
        }
    })
}
</script>
@endsection