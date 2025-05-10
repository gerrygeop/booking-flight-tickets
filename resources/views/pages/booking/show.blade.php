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
		<h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Booking Details</h1>
		<div class="flex gap-[30px] mt-[30px]">
			<div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">
				<div id="Flight-Info"
					class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
					<label class="flex items-center justify-between p-5">
						<h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>
						<img src="assets/images/icons/arrow-up-circle-black.svg"
							class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
						<input type="checkbox" class="hidden">
					</label>
					<div class="accordion-content p-5 pt-0 flex flex-col gap-5">
						<div class="flex justify-between">
							<div>
								<p class="text-sm text-garuda-grey">Departure</p>
								<p class="font-semibold text-lg">
									{{ $transaction->flight->segments->first()->airport->city }}
									({{ $transaction->flight->segments->first()->airport->iata_code }})
								</p>
							</div>
							<div class="text-end">
								<p class="text-sm text-garuda-grey">Arrival</p>
								<p class="font-semibold text-lg">
									{{ $transaction->flight->segments->last()->airport->city }}
									({{ $transaction->flight->segments->last()->airport->iata_code }})
								</p>
							</div>
						</div>
						<div class="flex justify-between">
							<div>
								<p class="text-sm text-garuda-grey">Date</p>
								<p class="font-semibold text-lg">
									{{ $transaction->flight->segments->first()->time->format('d M y') }}
								</p>
							</div>
							<div class="text-end">
								<p class="text-sm text-garuda-grey">Quantity</p>
								<p class="font-semibold text-lg">{{ $transaction->number_of_passengers }} people</p>
							</div>
						</div>

						<div class="flex flex-col rounded-[20px] border border-[#E8EFF7] p-5 gap-5">
							<div class="flex flex-col gap-4">
								<div class="flex items-center justify-between">
									<div class="flex items-center gap-[10px]">
										<img src="{{ asset('storage/' . $transaction->flight->airline->logo) }}" class="h-[100px] flex shrink-0"
											alt="logo">
									</div>
									<a href="#" class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
										<p class="font-semibold text-white">Details</p>
									</a>
								</div>
								<div class="flex items-center justify-between">
									<div>
										<p class="font-semibold">
											{{ $transaction->flight->airline->name }}
										</p>
										<p class="text-sm text-garuda-grey mt-[2px]">
											{{ $transaction->flight->segments->first()->time->format('H:i') }}
											-
											{{ $transaction->flight->segments->last()->time->format('H:i') }}
										</p>
									</div>
									<div class="flex flex-col gap-[2px] items-center justify-center">
										<p class="text-sm text-garuda-grey">
											{{ number_format($transaction->flight->segments->first()->time->diffInHours($transaction->flight->segments->last()->time), 0) }}
											hours
										</p>
										<div class="flex items-center gap-[6px]">
											<p class="font-semibold">
												{{ $transaction->flight->segments->first()->airport->iata_code }}
											</p>
											@if ($transaction->count() > 2)
												<img src="{{ asset('assets/images/icons/transit-black.svg') }}" alt="icon">
											@else
												<img src="{{ asset('assets/images/icons/direct-black.svg') }}" alt="icon">
											@endif
											<p class="font-semibold">
												{{ $transaction->flight->segments->last()->airport->iata_code }}
											</p>
										</div>
										<p class="text-sm text-garuda-grey">
											@if ($transaction->flight->segments->count() > 2)
												Transit {{ $transaction->flight->segments->count() - 2 }}x
											@else
												Direct
											@endif
										</p>
									</div>
								</div>
							</div>

							<hr class="border-[#E8EFF7]">

							<div class="flex items-center rounded-[20px] gap-[14px]">
								<div class="flex w-[120px] h-[100px] shrink-0 rounded-[20px] overflow-hidden">
									<img src="assets/images/thumbnails/economy-seat.png" class="w-full h-full object-cover" alt="icon">
								</div>
								<div>
									<p class="font-bold text-xl leading-[30px]">{{ str()->ucfirst($transaction->class->class_type) }} Class</p>
									<p class="text-garuda-grey mt-1">
										{{ 'Rp.' . number_format($transaction->class->price, 0, ',', '.') }}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="Transaction-Info"
					class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
					<label class="flex items-center justify-between p-5">
						<h2 class="font-bold text-xl leading-[30px]">Transaction Details</h2>
						<img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
							class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
						<input type="checkbox" class="hidden">
					</label>

					<div class="accordion-content p-5 pt-0 flex flex-col gap-5">
						<div class="flex justify-between">
							<div>
								<p class="text-sm text-garuda-grey">Booking Transaction ID</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									{{ $transaction->code }}
								</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey text-end">Payment Status</p>
								<div class="flex items-center justify-end gap-[10px] mt-[2px]">
									@if ($transaction->payment_status === 'pending')
										<p class="rounded-full p-[6px_12px] bg-garuda-orange font-bold text-sm">PENDING</p>
									@else
										<p class="rounded-full p-[6px_12px] bg-garuda-green font-bold text-sm text-white">
											SUCCESS
										</p>
									@endif
								</div>
							</div>
						</div>
						<div class="flex justify-between">
							<div>
								<p class="text-sm text-garuda-grey">Quantity</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									{{ $transaction->number_of_passengers }} People
								</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey">Tiers</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									{{ str()->ucfirst($transaction->class->class_type) }}
								</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey">Seats</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									@foreach ($transaction->passengers as $passenger)
										{{ $passenger->seat->name }}
										@if (!$loop->last)
											,
										@endif
									@endforeach
								</p>
							</div>
						</div>

						<div class="flex justify-between">
							<div>
								<p class="text-sm text-garuda-grey">Price</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									{{ 'Rp.' . number_format($transaction->class->price, 0, ',', '.') }}
								</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey">Govt. Tax</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">11%</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey">Sub Total</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									{{ 'Rp.' . number_format($transaction->class->price * $transaction->number_of_passengers, 0, ',', '.') }}
								</p>
							</div>
						</div>

						<div class="flex justify-between items-center">
							<div>
								<p class="text-sm text-garuda-grey">Discount</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px] text-garuda-green">
									@if ($transaction->promo)
										@php
											$discountAmount = 0;
											if ($transaction->promo->discount_type === 'percentage') {
											    $discountAmount = $transaction->subtotal * ($transaction->promo->discount / 100);
											} else {
											    $discountAmount = $transaction->promo->discount;
											}
										@endphp

										@if ($transaction->promo->discount_type === 'percentage')
											{{ '%' . number_format($discountAmount, 0, ',', '.') }}
										@else
											{{ 'Rp.' . number_format($discountAmount, 0, ',', '.') }}
										@endif
									@else
										-
									@endif
								</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey">Promo Code</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									@if ($transaction->promo)
										{{ $transaction->promo->code }}
									@else
										-
									@endif
								</p>
							</div>
						</div>

						<div class="flex justify-between items-center">
							<div>
								<p class="text-sm text-garuda-grey">Total Tax</p>
								<p class="font-semibold text-lg leading-[27px] mt-[2px]">
									{{ 'Rp.' . number_format($transaction->class->price * $transaction->number_of_passengers * 0.11, 0, ',', '.') }}
								</p>
							</div>
							<div>
								<p class="text-sm text-garuda-grey">Grand Total</p>
								<p class="font-bold text-2xl leading-9 text-garuda-blue mt-[2px]">
									{{ 'Rp.' . number_format($transaction->class->price * $transaction->number_of_passengers * 1.11, 0, ',', '.') }}
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="Right-Content" class="flex flex-col gap-[30px] w-[490px] shrink-0">
				<div id="Customer-Info"
					class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
					<label class="flex items-center justify-between p-5">
						<h2 class="font-bold text-xl leading-[30px]">Customer Information</h2>
						<img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
							class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
						<input type="checkbox" class="hidden">
					</label>

					<div class="accordion-content p-5 pt-0 flex flex-col gap-5">
						<label class="flex flex-col gap-[10px]">
							<p class="font-semibold">Complete Name</p>
							<div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
								<img src="{{ asset('assets/images/icons/profile-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
								<p class="font-semibold">
									{{ $transaction->name }}
								</p>
							</div>
						</label>
						<label class="flex flex-col gap-[10px]">
							<p class="font-semibold">Email Address</p>
							<div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
								<img src="{{ asset('assets/images/icons/sms-black.png') }}" class="w-5 flex shrink-0" alt="icon">
								<p class="font-semibold">
									{{ $transaction->email }}
								</p>
							</div>
						</label>
						<label class="flex flex-col gap-[10px]">
							<p class="font-semibold">Phone No.</p>
							<div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
								<img src="{{ asset('assets/images/icons/call-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
								<p class="font-semibold">
									{{ $transaction->phone }}
								</p>
							</div>
						</label>
					</div>
				</div>

				@foreach ($transaction->passengers as $passenger)
					<div id="Passenger-1"
						class="accordion-with-select group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden transition-all duration-300">
						<button type="button" class="accordion-btn flex items-center justify-between p-5">
							<h2 class="font-bold text-xl leading-[30px]">Passenger {{ $loop->index + 1 }}</h2>
							<img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
								class="arrow w-9 h-8 transition-all duration-300" alt="icon">
						</button>

						<div class="accordion-content p-5 pt-0 flex flex-col gap-5">
							<label class="flex flex-col gap-[10px]">
								<p class="font-semibold">Complete Name</p>
								<div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
									<img src="{{ asset('assets/images/icons/profile-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
									<p class="font-semibold">
										{{ $passenger->name }}
									</p>
								</div>
							</label>
							<div class="flex flex-col gap-[10px]">
								<p class="font-semibold">Date of Birth</p>
								<div class="flex items-center gap-[10px]">
									<div class="flex items-center w-full rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
										<img src="{{ asset('assets/images/icons/note-add-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
										<p class="font-semibold">
											{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('d') }}
										</p>
									</div>
									<div class="flex items-center w-full rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
										<img src="{{ asset('assets/images/icons/note-add-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
										<p class="font-semibold">
											{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('m') }}
										</p>
									</div>
									<div class="flex items-center w-full rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
										<img src="{{ asset('assets/images/icons/note-add-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
										<p class="font-semibold">
											{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('Y') }}
										</p>
									</div>
								</div>
							</div>
							<label class="flex flex-col gap-[10px]">
								<p class="font-semibold">Nationality</p>
								<div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
									<img src="{{ asset('assets/images/icons/global-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
									<p class="font-semibold">
										{{ $passenger->nationality }}
									</p>
								</div>
							</label>
						</div>
					</div>
				@endforeach

				<a href="#"
					class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
					<span class="font-semibold text-white">Download .PDF Version</span>
				</a>
			</div>
		</div>
	</main>
@endsection
