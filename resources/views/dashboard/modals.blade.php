<!-- Modal for creating a new timetable -->
<div class="modal custom-modal" id="resource-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                {{-- <h4 class="modal-heading">Create New Timetables</h4> --}}
                <h4 class="modal-heading"></h4>
            </div>
            
            <form class="form" method="POST" action="" id="resource-form">
                <input type="hidden" name="_method" value="">
                <div class="modal-body">
                    <div id="errors-container">
                        @include('partials.modal_errors')
                    </div>

                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>School Year</label>
                                <select name="name" class="form-control">
                                    <option value="" selected>Select School Year</option>
                                    @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                                        <option value="{{ $year . '-' . ($year + 1) }}">{{ $year . '-' . ($year + 1) }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Academic Period</label>
                                <div class="select2-wrapper">
                                    <select class="form-control select2" name="academic_period_id">
                                        <option value="" selected>Select an academic period</option>
                                        @foreach ($academicPeriods as $period)
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Select Days</label>

                                <div name="days">
                                    <div class="form-group">
                                        <input id="MTh" type="checkbox" name="MTh">
                                        <label for="MTh">MTh</label>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input id="TF" type="checkbox" name="TF">
                                        <label for="TF">TF</label>
                                    </div>

                                    <div class="form-group">
                                        <input id="WS" type="checkbox" name="WS">
                                        <label for="WS">WS</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-offset-1 col-md-offset-1">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <button type="submit" class="submit-btn btn btn-primary btn-block">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>