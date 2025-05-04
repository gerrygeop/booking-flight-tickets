@extends('layouts.app')
@section('include')
	<div id="Background-home" class="absolute w-full h-full top-0 bg-white">
		<div
			class="absolute top-0 w-full h-[1020px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F5F6FB_77.08%,#FFFFFF_100%)]">
			<img src="{{ asset('assets/images/backgrounds/Jumbo Jet Sky (1) 1.png') }}"
				class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
		</div>
	</div>
@endsection
@section('content')
	<main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
		<a href="{{ route('flight.index') }}"
			class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
			<img src="{{ asset('assets/images/icons/arrow-left-white.svg') }}" class="w-6 h-6" alt="icon">
			<p class="font-semibold text-white">Back to Choose Flight</p>
		</a>
		<h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Choose Tiers</h1>
		<div class="flex gap-[30px] mt-[30px]">
			<div id="Flight-Info" class="flex flex-col w-[470px] shrink-0 h-fit rounded-[20px] bg-white p-5 gap-5">
				<h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>
				<div class="flex justify-between">
					<div>
						<p class="text-sm text-garuda-grey">Departure</p>
						<p class="font-semibold text-lg">
							{{ $flight->segments->first()->airport->city }} ({{ $flight->segments->first()->airport->iata_code }})
						</p>
					</div>
					<div class="text-end">
						<p class="text-sm text-garuda-grey">Arrival</p>
						<p class="font-semibold text-lg">
							{{ $flight->segments->last()->airport->city }} ({{ $flight->segments->last()->airport->iata_code }})
						</p>
					</div>
				</div>
				<div class="flex justify-between">
					<div>
						<p class="text-sm text-garuda-grey">Date</p>
						<p class="font-semibold text-lg">
							{{ $flight->segments->first()->time->format('d M y') }}
						</p>
					</div>
					<div class="text-end">
						<p class="text-sm text-garuda-grey">Quantity</p>
						<p class="font-semibold text-lg">3 people</p>
					</div>
				</div>
				<div class="flex flex-col rounded-[20px] border border-[#E8EFF7] p-5 gap-5">
					<div class="flex flex-col gap-4">
						<div class="flex items-center justify-between">
							<div class="flex items-center gap-[10px]">
								<img src="{{ asset('storage/' . $flight->airline->logo) }}" class="w-[60px] h-[60px] flex shrink-0"
									alt="logo">
								<div>
									<p class="font-semibold">
										{{ $flight->airline->name }}
									</p>
									<p class="text-sm text-garuda-grey mt-[2px]">
										{{ $flight->segments->first()->time->format('H:i') }}
										-
										{{ $flight->segments->last()->time->format('H:i') }}
									</p>
								</div>
							</div>
							<a href="#" class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
								<p class="font-semibold text-white">Details</p>
							</a>
						</div>
						<div class="flex items-center justify-between">
							<div class="flex flex-col gap-[2px] items-center justify-center">
								<p class="text-sm text-garuda-grey">
									{{ number_format($flight->segments->first()->time->diffInHours($flight->segments->last()->time), 0) }} hours
								</p>
								<div class="flex items-center gap-[6px]">
									<p class="font-semibold">
										{{ $flight->segments->first()->airport->iata_code }}
									</p>
									@if ($flight->segments->count() > 2)
										<img src="{{ asset('assets/images/icons/transit-black.svg') }}" alt="icon">
									@else
										<img src="{{ asset('assets/images/icons/direct-black.svg') }}" alt="icon">
									@endif
									<p class="font-semibold">
										{{ $flight->segments->last()->airport->iata_code }}
									</p>
								</div>
								<p class="text-sm text-garuda-grey">
									@if ($flight->segments->count() > 2)
										Transit {{ $flight->segments->count() - 2 }}x
									@else
										Direct
									@endif
								</p>
							</div>
							<p class="font-semibold text-garuda-green text-center">
								{{ 'Rp.' . number_format($flight->classes->first()->price, 0, ',', '.') }}
							</p>
						</div>
					</div>
				</div>
			</div>

			<form action="{{ route('booking', $flight->flight_number) }}" class="grid grid-cols-2 gap-x-[30px]">
				<input type="hidden" name="flight_class_id" value="" id="flight_class_id">
				@foreach ($flight->classes as $class)
					<div class="flex flex-col h-fit rounded-[20px] p-5 pb-[30px] gap-5 bg-white">
						<div class="w-[260px] h-[180px] rounded-[30px] bg-[#D9D9D9] overflow-hidden">
							@if ($class->class_type === 'economy')
								<img src="{{ asset('assets/images/thumbnails/economy-seat.png') }}" class="w-full h-full object-cover"
									alt="thumbnails">
							@else
								<img src="{{ asset('assets/images/thumbnails/business-seat.png') }}" class="w-full h-full object-cover"
									alt="thumbnails">
							@endif
						</div>

						<div class="flex flex-col gap-1">
							<p class="font-semibold text-lg">{{ str()->ucfirst($class->class_type) }} Class</p>
							<p class="font-extrabold text-[32px] leading-[48px]">
								{{ 'Rp.' . number_format($class->price, 0, ',', '.') }}
							</p>
						</div>

						<hr class="border-[#E8EFF7]">

						@foreach ($class->facilities as $facility)
							<div class="flex items-center gap-[10px]">
								<img src="{{ asset('storage/' . $facility->image) }}" class="w-6 h-6 flex shrink-0" alt="icon">
								<div>
									<p class="font-semibold">{{ $facility->name }}</p>
								</div>
							</div>
						@endforeach

						<button
							class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300"
							onclick="document.getElementById('flight_class_id').value={{ $class->id }}">
							<span class="font-semibold text-white">Choose</span>
						</button>
					</div>
				@endforeach
			</form>
		</div>
	</main>
@endsection
