   <div class="row mb-3">
      <div class="col-lg-7 col-md-8 col-12 mx-auto animate__animated animate__slower animate__{{$animation}} animate__repeat-3" style="display: none">
         <div class="rating w-100 bg-white rounded-pill p-3">
            <div class="d-apart">
               <div class="d-flex align-items-center mr-1">
                  <div class="mr-2" style="width: 78px">
                     @if($user->hasAvatar())
                     @include('components.avatar.image', ['size' => '78px'])
                     @else
                     @include('components.avatar.initial', ['size' => '78px', 'fontsize' => '1.8rem'])
                     @endif
                  </div>
                  <div class="mr-2">
                     <div class="d-flex flex-column">
                        <h3 class="mb-0 text-dark no-stroke">{{$user->name}}</h3>
                        <h3 class="mb-0 text-primary no-stroke">{{$song->name}}</h3>
                        <h6 class="mb-0 text-dark no-stroke opacity-8">{{$song->artist->name}}</h6>
                     </div>
                  </div>
               </div>
               <div class="d-flex">
                  <h6 class="mb-0 mr-2 text-secondary">({{$winner->count}})</h6>
                  @include('pages.ratings.stars', ['rating' => $winner->average, 'size' => 'lg'])
               </div>
            </div>
         </div>
      </div>
   </div>