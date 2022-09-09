@extends('layouts.dashboard')
@section('content')

<button onclick="addForm()" class="btn btn-success mb-4" data-toggle="modal" data-target="#modal-tag">Add Tag</button>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTable-tag" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tag name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- include modal form.blade.php --}}
@include('admin.tags.form')

@endsection


@section('script')
<script>
    let tableTag = $('#dataTable-tag').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.tag') }}",
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
        $('#modal-tag').modal('show');
        $('.modal-title').text('Add Tag');
        $('#modal-tag form')[0].reset();
    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-tag form')[0].reset();

        $.ajax({
            url: "{{ url('admin/tags') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#modal-tag").modal("show");
                $(".modal-title").text("Edit a Tag");

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
                    url: "{{ url('admin/tags') }}" + "/" + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        tableTag.ajax.reload();
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
        $('#save-tag').on('click', function(e) {
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
                    url = "{{ url('admin/tags') }}"
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
                    url = "{{ url('admin/tags') . '/' }}" + id;
                }

            }

            $.ajax({
                url: url,
                type: "POST",
                data: $("#modal-tag form").serialize(),
                success: function($data) {
                    $('#modal-tag').modal('hide');
                    tableTag.ajax.reload();
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