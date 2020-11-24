@extends('front-end.master')
@section('body')
<div class="row">
  <div class="col-md-12">
    <div class="card card-default" style="margin-top:0px;margin-bottom: 0px;">
      <div class="card-header">
        <i class="fa fa-picture-o"></i>Filter
        <div class="card-header-actions">
          <a class="card-header-action" href="" target="_blank"></a>
        </div>
      </div>
      <div class="card-body">
        <form id="filter_form">
          @csrf
          <div class="alert alert-info kk_alert kk_processing_alert" role="alert">
            <p class="text-center">Processing...</p>
          </div>
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul>

            </ul>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" id="level" name="level">
                    <option value="">Select Level</option>
                  @foreach($levels as $level)
                    <option @php echo($level->id == $level_id) ? 'selected' : '' @endphp value="{{$level->id}}"> {{$level->level_name}} </option>
                  @endforeach
                </select>
              </div> 
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Subject</label>
                <select class="form-control" id="subject" name="subject">
                    <option value="">Select Subject</option>
                  @foreach($subjects as $subject)
                    <option @php echo($subject->id == $subject_id) ? 'selected' : '' @endphp value="{{$subject->id}}"> {{$subject->subject_name}} </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card card-default" style="margin-top: 1.5rem;">
      <div class="card-header">
        <i class="fa fa-picture-o"></i><span id="subject_name">{{$subject_name}}</span>
        <div class="card-header-actions">
          <a class="card-header-action" href="" target="_blank"></a>
        </div>
      </div>
      <div class="card-body">
        <div id="study_content">
          @include('front-end.book.study-content')
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('.kk_processing_alert').hide();
  $('#paginate_loading').hide();
  $("body").delegate(".pagination a", "click", function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $('#paginate_loading').show();
    getStock(url);
  });
  function getStock(url) {
    var form = $("#filter_form");
    $.ajax({
      type:"POST",
      url : url,
      dataType:'json',
      data:form.serialize(),
      }).done(function (data) {
        $('#subject_name').html(data.success.subject_name);
        $('#study_content').html(data.success.view);
        $('#paginate_loading').hide();
      }).fail(function () {
        $('#paginate_loading').hide();
        alert('Data could not be loaded.');
      });
  }
  $("#level").change(function(){
  var form = $("#filter_form");
  $('.kk_processing_alert').show();
    $.ajax({
      type:"POST",
      url: '{{route('filter_study')}}',
      dataType:'json',
      data:form.serialize(),
      success:function(data){
        $('.kk_processing_alert').hide();
        if($.isEmptyObject(data.error)){
          $("#subject").html(data.success);
          $(".print-error-msg").css('display','none');
        }else{
          printErrorMsg(data.error);
        }
      }
    });
  });
  $("#subject").change(function(){
    var form = $("#filter_form");
    $('.kk_processing_alert').show();
    $.ajax({
      type:"POST",
      url: '{{route('filter_study')}}',
      dataType:'json',
      data:form.serialize()+"&study=1",
      success:function(data){
        $('.kk_processing_alert').hide();
        if($.isEmptyObject(data.error)){
            $("#subject_name").html(data.success.subject_name);
            $("#study_content").html(data.success.view);
            $(".print-error-msg").css('display','none');
        }else{
          printErrorMsg(data.error);
        }
      }
    });
  });
  function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
      $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
  }
</script>
@endsection
