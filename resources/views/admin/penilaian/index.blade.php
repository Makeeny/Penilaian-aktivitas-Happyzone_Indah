@extends('layouts.admin')

@section('content')
<h2>Penilaian: {{ $kriterias->first()->mapel->nama }}</h2>
<table>
  <thead>
    <tr>
      <th>Siswa</th>
      @foreach($kriterias as $k) <th>{{ $k->nama }} ({{ $k->bobot }}%)</th> @endforeach
      <th>Skor Akhir</th>
    </tr>
  </thead>
  <tbody>
    @foreach($siswas as $s)
      <tr>
        <td>{{ $s->nama }}</td>
        @foreach($kriterias as $k)
          <td>{{ number_format(Penilaian::where([...])->value('nilai') ?? 0,2) }}</td>
        @endforeach
        <td>{{ number_format($scores[$s->id],4) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
