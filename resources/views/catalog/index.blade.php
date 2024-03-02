@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />
@endsection
@section('content')
<div class="container">
    <div class="row">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">description</th>
                    <th scope="col">price</th>
                    <th scope="col" class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { 
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'cover_url',
                    name: 'image',
                    width: '20%',
                    orderable: false,
                    searchable: false,
                    render: function( data, type, full, meta ) {
                        return "<img src=\"/path/" + data + "\" height=\"50\"/>";
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    width: '20%',
                    orderable: true,
                    serchable: true
                },
                {
                    data: 'description',
                    name: 'description',
                    width: '20%',
                    orderable: true,
                    serchable: true
                },
                {
                    data: 'price',
                    name: 'price',
                    width: '20%',
                    orderable: true,
                    serchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '10%',
                    orderable: false,
                    serchable: false
                }
            ],
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                }                     
            ],
            order: [[ 0, "desc" ]]
        });
    });
</script>
@endpush