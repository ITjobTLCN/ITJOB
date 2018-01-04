<div class="box related-jobs">
    <div class="header-top">
       <a href="{{route('/')}}">Related Jobs</a>
   </div>
   <div class="wrap">
       <ul class="jobs">
        @foreach($relatedJob as $rl)
            <li class="item-job">
                 <a href="{{route('detailjob',[$rl->alias,$rl->id])}}" title="{{$rl->name}}">
                    <div class="title">{{$rl->name}}</div>
                    <div>
                         <span class="company">{{$rl->en}}</span>
                         <span class="location"><i class="fa fa-map-marker"></i> {{$rl->cn}}</span>
                    </div>
                     <div>
                         <span class="salary"><i class="fa fa-wifi" aria-hidden="true"></i> @if(Auth::check()){{$rl->salary}}
                          @else 
                          <a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
                          @include('partials.modal-login')
                          @endif
                      </span>
                  </div>
                  <div>
                     <span class="tag-skill">C++</span>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>