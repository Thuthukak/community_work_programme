@extends('layout.crm')
@section('style')
    
@stop
@section('title', $ticket->title)

@section('main-section')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4>
                <div class="mb-2">#{{ $department->title }} - {{ __('theme.department_ticket') }}</div>
                <hr>
                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
            </h4>
          </div>
        </div>
      </div>
    </section>
    @include('includes.flash')
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
                    {!! clean($ticket->message) !!}
                    <hr>
                    <div class="">
                      @foreach($ticket->ticketCustomField as $customField)
                        @if($customField->fields->type == 'file')
                          <div>
                              <strong>{{ $customField->fields->name }}</strong>:
                            <div>
                                @if(checkFileExtension($customField->value) == 'png' || checkFileExtension($customField->value) == 'jpg' || checkFileExtension($customField->value) == 'jpeg' || checkFileExtension($customField->value) == 'svg' || checkFileExtension($customField->value) == 'gif')
                                    <a href="{{ asset(symImagePath().$customField->value) }}" target="_blank">
                                        <img src="{{ asset(symImagePath().$customField->value) }}" class="img-fluid img-thumbnail w-50" />
                                    </a>
                                @else
                                    <a href="{{ asset(symImagePath().$customField->value) }}" target="_blank">View Attachment</a>
                                @endif
                            </div>
                          </div>
                        @else
                          <p><strong>{{ $customField->fields->name }}</strong>: {{ $customField->value }}</p>
                        @endif
                      @endforeach
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
                @forelse ($comments as $comment)
                <div>
                    <i class="fa fa-comments bg-yellow"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="fas fa-clock"></i> {{ $comment->created_at->toDayDateTimeString() }}</span>
                      <h3 class="timeline-header"><a href="javascript:void(0);">{{ $comment->user->name }}</a> {{ __('theme.commented_on_your_ticket') }}</h3>
                        <div class="timeline-body">
                            {!! clean($comment->comment) !!}
                        </div>
                    </div>
                </div>
                @empty
                <div>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            {{ __('theme.no_reply_found') }}
                        </div>
                    </div>
                </div>
                @endforelse
              <!-- /.timeline-label -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.timeline -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-pencil"></i> {{ __('theme.reply_ticket') }}</h3>
                    </div>
                    @if($ticket->status != 'Closed')
                    <div class="card-body">
                        <form role="form" class="m-0" method="POST" action="{{ route('comment.postComment') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <textarea class="textarea my-editor" name="comment" placeholder="{{ __('theme.place_of_answer') }}">{{ clean(old('comment')) }}</textarea>
                            @error('comment')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-group">
                                <label for="title">{{ __('theme.status') }}</label><br>
                                <div class="form-check-inline">
                                    <label class="customradio"><span class="radiotextsty">{{ __('theme.open') }}</span>
                                      <input type="radio" checked="checked" name="status" value="Open" required>
                                      <span class="checkmark"></span>
                                    </label>        
                                    <label class="customradio"><span class="radiotextsty">{{ __("theme.closed") }}</span>
                                      <input type="radio" name="status" value="Closed" required>
                                      <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('theme.submit_reply') }}</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="card-body">
                        {{ __("theme.you_can't_reply_because_ticket_closed") }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
      </div>
    </section>

@endsection

@section('js')
  <script src="{{asset('src/public/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('tinymce/script.js')}}"></script>
@endsection