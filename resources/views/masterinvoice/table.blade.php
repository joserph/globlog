<!-- Main content -->
<div class="invoice p-3 mb-3">
   <!-- title row -->
   <table class="table table-sm table-hover">
      <thead>
         <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Dirección</th>
            <th scope="col">Estado</th>
            <th scope="col">Ciudad</th>
            <th scope="col">País</th>
            <th scope="col">País</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($invoiceheaders as $invoice)
           <tr>
              <td>{{ $invoice->date }}</td>
              <td>{{ $invoice->bl }}</td>
              <td>{{ $invoice->carrier }}</td>
              <td>{{ $invoice->invoice }}</td>
              <td>{{ $invoice->id_company }}</td>
              <td>{{ $invoice->id_load }}</td>
              <td>{{ $invoice->id_logistics_company }}</td>
           </tr>
         @endforeach
      </tbody>
   </table>
</div>
    