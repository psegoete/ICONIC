<div class="">
    @foreach($ticket->comments as $comment)
    @if($comment->comment || $comment->file_name)
        <blockquote class="blockquote">
            <p style="color:white; padding-left:10px;padding:right:10px; padding-top:10px"> 
                <div class="container clearfix">
                    <div class="chat">   
                      <div class="chat-history">
                        <ul class="chat-ul">
                            @if ($comment->user_comment_id == Auth::user()->id)
                            <li class="clearfix">
                                <div class="message-data">
                                  <span class="message-data-name"><i class="fa fa-circle you"></i> @if(Auth::user()->ticket_display_name ) {{ Auth::user()->ticket_display_name }} @else {{ Auth::user()->name}} @endif</span>
                                </div>
                                @if($comment->comment)
                                <div class="message you-message">
                                  {{ $comment->comment }}
                                </div>
                                @endif
                              </li>
                              @if($comment->file_name)
                              <li class="clearfix">
                                  <div class="message-data">
                                    {{-- <span class="message-data-name"><i class="fa fa-circle you"></i> {{ Auth::user()->name }}</span> --}}
                                  </div>
                                  <div class="message you-message" align="center">
                                    <a href="{{ url('account/comment/' .$comment->id) }}">
                                      <div style="ontent: "\F0C6";position: absolute;top: 12px;left: 50%;transform: translateX(-50%);font-size: 24px;">
                                        <i class="fa fa-paperclip"></i>
                                      </div>
                                      <div style="ontent: "\F0C6";position: absolute;top: 12px;left: 50%;transform: translateX(-50%);font-size: 24px;">
                                        {{ $comment->file_name_title }}
                                    </div>
                                    </a> 
                                  </div>
                                </li>
                              @endif
                            @else
                            <li class="clearfix">
                                  <div class="message-data align-right">
                                    <span class="message-data-name">@if(\CreatyDev\Domain\Users\Models\User::find($comment->user_comment_id)->ticket_display_name ) {{ \CreatyDev\Domain\Users\Models\User::find($comment->user_comment_id)->ticket_display_name }} @else {{ \CreatyDev\Domain\Users\Models\User::find($comment->user_comment_id)->name }} @endif</span> <i class="fa fa-circle me"></i>
                                  </div>
                                  @if($comment->comment)
                                  <div class="message me-message float-right">
                                    {{ $comment->comment }}
                                  </div>
                                  @endif
                              </li>
                              @if($comment->file_name)
                                <li class="clearfix">
                                      <div class="message-data align-right">
                                        {{-- <span class="message-data-name">{{ $comment->user->name }}</span> <i class="fa fa-circle me"></i> --}}
                                      </div>

                                      <div class="message me-message float-right">
                                        
                                        <a href="{{ url('account/comment/' .$comment->id) }}" class="float-right1" align="center">
                                          <div style="ontent: "\F0C6";position: absolute;top: 12px;left: 50%;transform: translateX(-50%);font-size: 24px;">
                                          <i class="fa fa-paperclip"></i>
                                        </div>
                                          <div style="ontent: "\F0C6";position: absolute;top: 12px;left: 50%;transform: translateX(-50%);font-size: 24px;">
                                            {{ $comment->file_name_title }}
                                        </div>
                                         </a> 
                                      </div>
                                  </li>
                              @endif
                            @endif
                        </ul>
                        
                      </div>
                      
                    </div> 
                   
                  </div>
            </p>
            <footer class="blockquote-footer" style="font-size:14px; color:#c5cfda">
                {{ $comment->created_at }} 
            </footer>
        </blockquote>
        @endif
    @endforeach
</div>