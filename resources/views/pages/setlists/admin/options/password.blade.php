@if($gig->password()->required())
<a class="btn btn-secondary mb-3 w-100" target="_blank" href="{{route('gig.password', $gig)}}">Projetar senha</a>
@endif