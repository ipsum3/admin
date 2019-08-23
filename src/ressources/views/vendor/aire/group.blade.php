<?php /** @var \Galahad\Aire\Elements\Attributes\Collection $attributes */ ?>

<div {{ $attributes }}>
	{{ $label }}

	@if($prepend)
		<div {{ $attributes->prepend }}>
			{{ $prepend }}
		</div>
	@endif

	{{ $element }}

	@if($append)
		<div {{ $attributes->append }}>
			{{ $append }}
		</div>
	@endif
	
	<ul {{ $attributes->errors }}>
		@each($error_view, $errors, 'error')
	</ul>
	
	@isset($help_text)
		<span {{ $attributes->help_text }}>
			{{ $help_text }}
		</span>
	@endisset
	
</div>
