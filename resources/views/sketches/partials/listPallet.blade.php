<div class="card-body" style="display: none;">
    <div class="table-responsive">
       @if($item->id_pallet)
       <table class="table table-sm table table-bordered">
          <thead>
          <tr>
             <th class="text-center">Finca</th>
             <th class="text-center">Cliente</th>
             <th class="text-center">Piso</th>
             <th class="text-center">HB</th>
             <th class="text-center">QB</th>
             <th class="text-center">EB</th>
             <th class="text-center">Total</th>
          </tr>
          </thead>
          <tbody>
             @php
                $hb = 0; $qb = 0; $eb = 0; $total = 0;
             @endphp
             @foreach ($palletsItems as $item2)
                @if($item->id_pallet == $item2->id_pallet)
                   @php 
                      $hb+=$item2->hb;
                      $qb+=$item2->qb;
                      $eb+=$item2->eb;
                      $total+=$item2->quantity;
                   @endphp
                   <tr>
                      <td>
                         @foreach ($farms as $farm)
                            @if($item2->id_farm == $farm->id)
                               <small>{{ Str::limit(strtoupper($farm->name), '17') }}</small>
                            @endif
                         @endforeach
                      </td>
                      <td class="text-center">
                         @foreach ($clients as $client)
                            @if($item2->id_client == $client->id)
                               <small>{{ Str::limit(str_replace('SAG-', '', $client->name), '8') }}</small>
                            @endif
                         @endforeach
                      </td>
                      <td class="text-center">
                         @if($item2->piso == 1)
                         <span class="badge badge-warning">SI</span>
                         @endif
                      </td>
                      <td class="text-center">{{ $item2->hb }}</td>
                      <td class="text-center">{{ $item2->qb }}</td>
                      <td class="text-center">{{ $item2->eb }}</td>
                      <td class="text-center">{{ $item2->quantity }}</td>
                   </tr>
                   
                @endif
             @endforeach
          </tbody>
          <tfoot>
             <tr>
                <th colspan="3" class="text-center">Totales</th>
                <th class="text-center">{{ $hb }}</th>
                <th class="text-center">{{ $qb }}</th>
                <th class="text-center">{{ $eb }}</th>
                <th class="text-center">{{ $total }}</th>
             </tr>
         </tfoot>
       </table>
       @endif
    </div>
       
       
 </div>