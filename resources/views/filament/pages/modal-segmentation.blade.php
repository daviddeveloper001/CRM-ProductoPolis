<div>
    @if (!$customersByPaymentMethod['query']->isEmpty())
        <h2 class="text-lg font-bold">Clientes por Método de Pago</h2>

        <ul class="list-disc list-inside">

            @foreach ($customersByPaymentMethod['payments'] as $payment)
                @if ($payment->customers_count != 0)
                    <li>
                        <strong>{{ $payment->name }}</strong>:
                        {{ $payment->customers_count ?? 0 }} clientes
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    @if (!$getCustomersByAlert['query']->isEmpty())
        <h2 class="text-lg font-bold mt-6">Clientes por Alertas</h2>
        <ul class="list-disc list-inside">
            @foreach ($getCustomersByAlert['alerts'] as $alert)
                @if ($alert->customers_count != 0)
                    <li>
                        <strong>{{ $alert->type }}</strong>:
                        {{ $alert->customers_count ?? 0 }} clientes
                    </li>
                @endif
            @endforeach
        </ul>

    @endif


    @if (!$getCustomersBySeller['query']->isEmpty())
        <h2 class="text-lg font-bold mt-6">Clientes por Vendedor</h2>
        <ul class="list-disc list-inside">

            @foreach ($getCustomersBySeller['sellers'] as $seller)
                @if ($seller->customers_count != 0)
                    <li>
                        <strong>{{ $seller->name }}</strong>:
                        {{ $seller->customers_count ?? 0 }} clientes
                    </li>
                @endif
            @endforeach
        </ul>

    @endif

    @if (!$getCustomersBySegmentation['query']->isEmpty())
        <h2 class="text-lg font-bold mt-6">Clientes por Segmentación</h2>
        <ul class="list-disc list-inside">
            @foreach ($getCustomersBySegmentation['segmentations'] as $segmentation)
                @if ($segmentation->customers_count != 0)
                    <li>
                        <strong>{{ $segmentation->type }}</strong>:
                        {{ $segmentation->customers_count ?? 0 }} clientes
                    </li>
                @endif
            @endforeach
        </ul>
    @endif


    @if (!$customersByCity['query']->isEmpty())
        <h2 class="text-lg font-bold mt-6">Clientes por Ciudad</h2>
        <ul class="list-disc list-inside">
            @foreach ($customersByCity['cities'] as $city)
                @if ($city['customers_count'] != 0)
                    <li>
                        <strong>{{ $city['name'] }}</strong>:
                        {{ $city['customers_count'] ?? 0 }} clientes
                    </li>
                @endif
            @endforeach
        </ul>
    @endif


    {{-- @if ($customersByCity->isEmpty())
        <h2 class="text-lg font-bold mt-6">Clientes por Ciudad</h2>
        <ul class="list-disc list-inside">
            @if ($customersByCity->count() != 0)
                @foreach ($customersByCity as $customer)
                    <li>{{ $customer->name }} ({{ $customer->email }})</li>
                @endforeach
            @endif
        </ul>

    @endif --}}


</div>