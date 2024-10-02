@extends('layouts.crm')
@section('style')
    
@stop
@section('title', $ticket->title)

@section('contents')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4>  
                            <hr>
                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
            </h4>
          </div>
        </div>
      </div>
    </section>
    @include('tickets.flash')
    <section>
      <div class="container-fluid">
        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">{{ $ticket->created_at->toDayDateTimeString() }}</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fa fa-envelope bg-blue"></i>
                <div class="timeline-item">
                  <span class="time float-right"><i class="fa fa-clock-o"></i> {{ $ticket->created_at->diffForHumans() }}</span>
                  <h3 class="timeline-header"><a href="javascript:void(0);">{{ $ticket->user->name }}</a> {{ __('theme.sent_you_ticket_for_support') }}</h3>
                  <div class="timeline-body">
                    {!! $ticket->message !!}
                    <hr>
                    <div class="">
                    </div>
                  </div>
                  <div class="timeline-footer">
                    @if ($ticket->status === 'Open')
                        Status: <span class="badge bg-primary text-white">{{ $ticket->status }}</span>
                    @else
                        Status: <span class="badge bg-warning text-white">{{ $ticket->status }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-green">{{ __('theme.reply') }}</span>
              </div>
           
              <!-- /.timeline-label -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.timeline -->
       
    </section>

@endsection

@section('js')
  <script src="{{asset('src/public/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('tinymce/script.js')}}"></script>
@endsection