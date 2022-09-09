@extends('layouts.dashboard')
@section('content')

<button onclick="addForm()" class="btn btn-success mb-4" data-toggle="modal" data-target="#modal-category">Add Category</button>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTable-category" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Category name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- include modal form.blade.php --}}
@include('admin.categories.form')

@endsection

@section('script')
<script>
    let tableCategory = $('#dataTable-category').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.category') }}",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    })

    function addForm() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modal-category').modal('show');
        $('.modal-title').text('Add Category');
        $('#modal-category form')[0].reset();

    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-category form')[0].reset();

        $.ajax({
            url: "{{ url('admin/categories') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#modal-category").modal("show");
                $(".modal-title").text("Edit a category");

                $("#id").val(data.id);
                $("#name").val(data.name);
            },
            error: function() {
                alert("No Data");
            }
        })
    }

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
                    url: "{{ url('admin/categories') }}" + "/" + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        tableCategory.ajax.reload();
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


    $(function() {
        $('#save-category').on('click', function(e) {
            if (!e.isDefaultPrevented()) {
                let id = $('#id').val();

                // add data
                if(save_method == 'add') {
                    function sweetalert() {
                        return Swal.fire({
                            title: "Success!",
                            text: "Data has been saved",
                            icon: "success"
                        })
                    }
                    url = "{{ url('admin/categories') }}"
                }
                // edit data
                else {
                    function sweetalert() {
                        return Swal.fire({
                            title: "Success!",
                            text: "Data has been edited",
                            icon: "success"
                        })
                    }
                    url = "{{ url('admin/categories') . '/' }}" + id;
                }

            }

            $.ajax({
                url: url,
                type: "POST",
                data: $("#modal-category form").serialize(),
                success: function($data) {
                    $('#modal-category').modal('hide');
                    tableCategory.ajax.reload();
                    sweetalert();
                },
                error: function() {
                    Swal.fire({
                        title: "Oops!",
                        text: "Error! Something went wrong!",
                        icon: "error"
                    })
                }
            })

            return false;

        })
    })


</script>
@endsection