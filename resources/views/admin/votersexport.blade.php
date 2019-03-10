<h2>Voting Summary</h2>


<table  style="width: 100%">
<thead style="border: 1px solid gray">
  <tr style="background-color: gray;">
    <th scope="col" style="text-align: center;">Id</th>
    <th scope="col" style="text-align: center;">QR Code</th>
    <th scope="col" style="text-align: center;">Vote Status</th>
  </tr>
</thead>
<tbody >
    @foreach ($voters as $key => $voter)
        <tr>
            <th scope="row"style="text-align: center;"> {{ $key + 1 }}</th>
            <td style="text-align: center;">{{ $voter->qr_code }}</td>
            <td style="text-align: center; {{ $voter->has_voted ?  "background-color: #66ff66;": null }}">{{ $voter->has_voted ? 'Done' : 'Not Voted' }}</td>
        </tr>
    @endforeach
</tbody>
</table>