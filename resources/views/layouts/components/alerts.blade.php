@if($message = session('success'))
@alert([
    'color' => 'green',
    'headline' => 'Success',
    'message' => $message,
    'dismissible' => true,
    'countdown' => 2,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
@endif

@if($message = session('error') ?? $errors->first())
@alert([
    'color' => 'red',
    'headline' => 'Sorry',
    'message' => $message,
    'dismissible' => true,
    'countdown' => 2,
    'pos' => 'top',
    'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown']])
@endif