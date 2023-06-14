<script>
    function validateAndUpload(input, max_upload) {
        const fi = input;
        max_uploads = max_upload * 1000;
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {

                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= max_uploads) {
                    fi.value = "";
                    alert("File too Big, please select a file less than "+max_upload+" mb");
                } else {
                    document.getElementById('size').innerHTML = '<b>' +
                        file + '</b> KB';
                }
            }
        }
    }
</script>

<script>
    $("#nomor_ktp").on('keyup change', function() {
        val = $(this).val() || 0;
        if (isNaN(val)) {
            $(this).val("");
        }
    });
    $("#submitter_phone").on('keyup change', function() {
        val = $(this).val() || 0;
        if (isNaN(val)) {
            $(this).val("");
        }
    });
</script>

<script>
    $('#district_id').on('input', function(e) {
        $("#sub_district_id").removeAttr('disabled');
        $("#sub_district_id").html('<option value="">--PILIH--</option>');
    });

    $('#district_id').select2({
        ajax: {
            url: "{{ url('users/district?') }}",
            type: 'GET',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                var queryParameters = {
                    name: params.term,
                }
                return queryParameters;
            },
            processResults: function(params) {
                return {
                    results: $.map(params.data.districts, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    $('#activity_name').select2({
        tags: true,
        width: 'resolve',
    });
    $('#submitter, #submitter_optional').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
    $('#sub_district_id').select2({
        ajax: {
            url: "{{ url('users/sub-district?') }}",
            dataType: 'json',
            type: 'GET',
            delay: 300,
            data: function(params) {
                var queryParameters = {
                    name: params.term,
                    district_id: $("#district_id").val(),
                }
                return queryParameters;
            },
            processResults: function(params) {
                return {
                    results: $.map(params.data.sub_districts, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $(document).ready(function() {

        if (!$("#district_id").val()) {
            $("#sub_district_id").prop('disabled', true);
        }
        $(document).on('change', '#district_id', function(e) {
            if (!$("#district_id").val()) {
                $("#sub_district_id").prop('disabled', true);
            } else {
                $("#sub_district_id").prop('disabled', false);
            }
            $("#sub_district_id").val('').trigger('change');
        });
    });

    $("#status_tanah").change(function() {
        var val = $(this).val();
        console.log(val);
        if (val == 1) {
            $('#nomor_hak').val('HM.');
        } else if (val == 2) {
            $('#nomor_hak').val('HGB.');
        } else if (val == 3) {
            $('#nomor_hak').val('HGU.');
        } else if (val == 4) {
            $('#nomor_hak').val('HP.');
        } else if (val == 5) {
            $('#nomor_hak').val('HPL.');
        } else if (val == 6) {
            $('#nomor_hak').val('HSRS.');
        } else if (val == 8) {
            $('#nomor_hak').val('TN.');
        } else {
            $('#nomor_hak').val('No.');
        }
    });
</script>