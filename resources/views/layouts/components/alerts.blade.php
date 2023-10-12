@if(session('success') || session('status'))
@alert([
    'color' => 'green',
    'headline' => 'Show',
    'message' => session('success') ?? session('status'),
    'dismissible' => true,
    'countdown' => 4,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
@endif

@if($message = session('setlist-error'))
@modal([
    'title' => fa('exclamation-triangle').' Desculpe', 
    'id' => 'setlist-error-modal', 
    'autoshow' => true])
<div class="p-3 rounded mb-3 bg-white">
    <p class="text-left m-0 text-red h5 fw-bold">{{$message}}</p>
</div>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
@endmodal
@elseif($message = session('error') ?? $errors->first())
@alert([
    'color' => 'red',
    'headline' => 'Desculpe',
    'message' => $message,
    'dismissible' => true,
    'countdown' => 4,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
@endif

<div id="popup-success">
@alert([
    'color' => 'green',
    'headline' => 'Show',
    'hide' => true,
    'message' => '',
    'dismissible' => true,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
</div>

<div id="popup-error">
@alert([
    'color' => 'red',
    'headline' => 'Desculpe',
    'hide' => true,
    'message' => '',
    'dismissible' => true,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
</div>