<div style="font-size: 70%" class="fw-bold">
	<span class="opacity-6">{{$message->created_at->format('G:i')}}</span> 
	@if($verify)
	<span class="{{$message->isRead() ? 'text-green' : 'text-white opacity-4'}}">@fa(['icon' => 'check', 'mr' => 0])</span>
	@endif
</div>