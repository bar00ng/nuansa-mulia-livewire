<table>
    @foreach ($data['jobDetails'] as $detail)
    <thead>
        <tr>
            <th colspan="5" style="text-align: center;">
                {{ $detail['jobDetail_name'] }}
            </th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th colspan="5" style="text-align: center;">
                Materials
            </th>
        </tr>

        <tr>
            <th>
                Material
            </th>
            <th>
                Satuan
            </th>
            <th>
                Quantity
            </th>
            <th>
                Harga Satuan
            </th>
            <th>
                Total
            </th>
        </tr>

        @foreach ($detail['jobDetail_rab']['material'] as $material)
            <tr>
                <td>
                    {{ $material['_name'] ?? '-' }}
                </td>
                <td>
                    {{ $material['_satuan'] ?? '-' }}
                </td>
                <td>
                    {{ $material['_quantity'] ?? 0 }}
                </td>
                <td>
                    {{ $material['_harga_satuan'] ?? 0 }}
                </td>
                <td>
                    {{ $material['_total'] ?? 0 }}
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4">Subtotal Material</td>
            <td>
                {{  $detail['jobDetail_rab']['subtotal_material'] }}
            </td>
        </tr>

        <tr>
            @php
                $productionCost = $detail['jobDetail_rab']['production_cost'] ?? null;
            @endphp
            <th>
                Ongkos Produksi
            </th>
            <th>
                {{ $productionCost ? $productionCost->satuan : '-' }}
            </th>
            <th>
                {{ $productionCost ? $productionCost->quantity : 0 }}
            </th>
            <th>
                {{ $productionCost ? $productionCost->harga_satuan : 0 }}
            </th>
            <th>
                {{ $productionCost ? $productionCost->total_harga : 0 }}
            </th>
        </tr>

        <tr>
            @php
                $otherCost = $detail['jobDetail_rab']['other_cost'] ?? null;
            @endphp
            <th>
                Transport, Koordinasi, Alat Bantu, dll
            </th>
            <th>
                {{ $otherCost ? $otherCost->satuan : '-' }}
            </th>
            <th>
                {{ $otherCost ? $otherCost->quantity : 0 }}
            </th>
            <th>
                {{ $otherCost ? $otherCost->harga_satuan : 0 }}
            </th>
            <th>
                {{ $otherCost ? $otherCost->total_harga : 0 }}
            </th>
        </tr>

        <tr>
            <td colspan="4">Subtotal Ongkos Kerja</td>
            <td>
                {{ $detail['jobDetail_rab']['subtotal_ongkos_kerja'] ?? 0 }}
            </td>
        </tr>

        <tr>
            <td colspan="4">Total</td>
            <td>
                {{ $detail['jobDetail_rab']['total_biaya'] ?? 0 }}
            </td>
        </tr>

        <tr>
            <td>Lain- lain</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                {{ $detail['jobDetail_rab']['lain_lain'] ?? 0 }}
            </td>
            <td>
                {{ ($detail['jobDetail_rab']['lain_lain'] / 100) * $detail['jobDetail_rab']['total_biaya'] }}
            </td>
        </tr>

        {{-- Jasa kontrakto Section --}}
        <tr>
            <td>Jasa Kontraktor</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                {{ $detail['jobDetail_rab']['jasa_kontraktor'] ?? 0 }}
            </td>
            <td>
                {{ ($detail['jobDetail_rab']['jasa_kontraktor'] / 100) * $detail['jobDetail_rab']['total_biaya'] }}
            </td>
        </tr>


        {{-- Grand Total --}}
        <tr>
            <td colspan="4">Total</td>
            <td>
                {{ $detail['jobDetail_rab']['grand_total'] ?? 0}}
            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
    @endforeach
</table>
