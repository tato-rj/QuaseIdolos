   <div class="row mb-4">
      <div class="col-lg-7 col-md-8 col-12 mx-auto animate__animated animate__slower animate__{{$animation}} animate__repeat-3" style="display: none">
         <div class="rating w-100 bg-white rounded-pill p-3">
            <div class="d-apart">
               <div class="d-flex align-items-center mr-1 text-truncate">
                  <div class="mr-2" style="width: 78px">
                     @if($user->hasAvatar())
                     @include('components.avatar.image', ['size' => '78px'])
                     @else
                     @include('components.avatar.initial', ['size' => '78px', 'fontsize' => '1.8rem'])
                     @endif
                  </div>
                  <div class="mr-2 text-truncate">
                     <h3 class="mb-0 text-dark no-stroke text-truncate" style="font-size: 2.2rem">{{$user->name}}</h3>
                  </div>
               </div>
               <div class="d-flex">
                  @include('pages.ratings.stars', ['rating' => $winner->average, 'size' => 'lg'])
               </div>
            </div>
         </div>
      </div>
   </div>