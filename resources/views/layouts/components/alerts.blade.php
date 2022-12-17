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

@if($message = session('error') ?? $errors->first())
@alert([
    'color' => 'red',
    'headline' => 'Desculpe',
    'message' => $message,
    'dismissible' => true,
    'countdown' => 4,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
@endif