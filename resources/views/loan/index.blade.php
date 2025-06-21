@extends('layouts.layout')
@section('title')
    Loan
@endsection

@section('content')
    <div class="card p-4">
          @if (Auth::user()->role == 'admin')
                        
          <div class="">
              <a type="button" class="btn btn-success btn-sm btn-icon-text" href="{{route('loan.create')}}">
                  Add Data
                  <i class="typcn typcn-plus btn-icon-append"></i>
              </a>
          </div>
                    @endif
        <hr>
        <div class="table-responsive pt-3">
            <table id="data-table" class="table table-hover project-orders-table">
                <thead>
                    <tr>
                        <th class="ml-5">No.</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Borrowed At</th>
                        <th>Due At</th>
                        <th>Returned At</th>
                        <th>Status</th>
                        <th>Fine</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                {{$item->code}}
                            </td>
                            <td>
                                {{$item->user->name}}
                            </td>
                            <td>{{$item->borrowed_at}}</td>
                            <td>{{$item->due_at}}</td>
                            <td>{{$item->returned_at ?? "-"}}</td>
                            <td>
                                  @if (Auth::user()->role == 'admin')
                          @php
                                    $statusClass = match($item->status) {
                                        0 => 'bg-info text-white',
                                        1 => 'bg-success text-white',
                                        2 => 'bg-primary text-dark',
                                        3 => 'bg-warning text-dark',
                                        4 => 'bg-danger text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                @endphp

                                <form method="POST" action="{{ route('loan.updateStatus', $item->id) }}">
                                    @csrf
                                    @method('PATCH')

                                 <select
                                        name="status"
                                        class="form-select d-inline w-auto status-select {{ $statusClass }}"
                                        {{ (in_array($item->status, [2, 3]) || is_null($item->returned_at)) ? 'disabled' : '' }}
                                    >
                                        <option value={{0}} {{ $item->status == 0 ? 'selected' : '' }}>Borrowed</option>
                                        <option value={{1}} {{ $item->status == 1 ? 'selected' : '' }}>Returned</option>
                                        <option value={{2}} {{ $item->status == 2 ? 'selected' : '' }}>Approved</option>
                                        <option value={{3}} {{ $item->status == 3 ? 'selected' : '' }}>Overdue</option>
                                        <option value={{4}} {{ $item->status == 4 ? 'selected' : '' }}>Lost</option>
                                    </select>
                                </form>
                                @else
                                @switch($item->status)
                                @case(0)
                                <span class="badge bg-info text-white">Borrowed</span>
                                @break
            
                                @case(1)
                                <span class="badge bg-success text-white">Returned</span>
                                @break
            
                                @case(3)
                                <span class="badge bg-warning text-white text-dark">Approved</span>
                                @break
            
                                @case(4)
                                <span class="badge bg-warning text-white text-dark">Overdue</span>
                                @break
            
                                @case(5)
                                <span class="badge bg-danger text-white">Lost</span>
                                @break
            
                                @default
                                <span class="badge bg-secondary text-white">Unknown</span>
                                @endswitch
                              
                                @endif
                            </td>
                            <td>{{$item->fine}}</td>
                            <td>{{$item->createdBy->name}}</td>
                            <td>{{optional($item->updatedBy)->name ?? "-"}}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Edit Button -->
                                       @if (Auth::user()->role == 'admin')
                                    <a class="btn btn-warning btn-sm btn-icon-text mr-2 text-light"
                                        href="{{ route('loan.edit', $item->id) }}">
                                        Edit
                                        <i class="typcn typcn-edit btn-icon-append"></i>
                                    </a>
                                    @endif

                                    <!-- Detail Button -->
                                   
                                    <a class="btn btn-primary btn-sm btn-icon-text mr-2"
                                        href="{{ route('loan.show', $item->id) }}">
                                        Detail
                                        <i class="typcn typcn-eye btn-icon-append"></i>
                                    </a>
                                  

                                    <!-- Delete Button (in div, not directly in flex) -->
                                       @if (Auth::user()->role == 'admin')
                                    <div class="d-inline-block">
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('loan.destroy', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-icon-text"
                                                onclick="confirmDelete({{ $item->id }})">
                                                Delete
                                                <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                <img src="{{ asset('asset/image/noData.jpg') }}" alt="Tidak ada data"
                                    style="height: 40vh; width: 60vh; object-fit: contain;">
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function () {
                const form = this.closest('form');
                const selectedText = this.options[this.selectedIndex].text;

                Swal.fire({
                    title: 'Change Status?',
                    text: `Are you sure you want to change status to "${selectedText}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit hanya jika konfirmasi
                    } else {
                        // Reset ke value awal kalau dibatalkan
                        form.reset(); // atau simpan previous value di variable kalau perlu
                    }
                });
            });
        });
    </script>
@endsection