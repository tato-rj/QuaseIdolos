@if($gig->shouldFinish())
<h6 class="mb-4 text-center animate__animated animate__slower animate__infinite animate__flash">Terminará automaticamente a qualquer momento</h6>
@else
<h6 id="countdown-timer" class="mb-4 text-center" style="display: none">@fa(['icon' => 'clock'])Termina automaticamente em <span class="text-secondary" data-end="{{$gig->endingTime()->toDateTimeString()}}"></span></h6>
@endif