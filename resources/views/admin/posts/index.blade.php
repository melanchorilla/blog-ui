@extends('layouts.dashboard')
@section('content')

<a href="{{ route('posts.create') }}" class="btn btn-success mb-4">Add Post</a>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered" id="dataTable-post" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- include modal form.blade.php --}}

@endsection

@section('script')

<script>
    let tablePost = $("#dataTable-post").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.post') }}",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    })

    function deleteData(id) {
        let csrf_token = $('meta[name="csrf-token"]').attr('content');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: "Confirmation",
            text: "Are you sure want to delete this data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/posts') }}" + "/" + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        tablePost.ajax.reload();
                        swalWithBootstrapButtons.fire(
                            'Success',
                            'Data has been deleted!',
                            'success',
                        )
                    },
                    error: function() {
                        swalWithBootstrapButtons.fire(
                            'Oops !',
                            'Something went wrong!',
                            'error',
                        )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Data hasn\'t been deleted!',
                    'error'
                )
            }
        })

    }
</script>


@endsection