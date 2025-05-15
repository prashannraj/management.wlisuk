<p>Attach Files</p>
<div class="attachment-list">
    <input type="file" name='attachments[]' class="form-control">
</div>
<button class="btn-sm mt-2 btn-primary" id="addField">
    <i class="fa fa-plus"></i>
</button>


@push("scripts")
<script>
    $(document).ready(function() {
        function addField(e) {
            e.preventDefault();
            var field = '<input type="file" name="attachments[]" class="form-control">';
            $(".attachment-list").append(field);
        }

        $("#addField").on('click', addField);
    });
</script>

@endpush