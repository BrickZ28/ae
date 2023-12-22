<script>
    const button = document.getElementById('kt_docs_sweetalert_basic');

    button.addEventListener('click', e =>{
        e.preventDefault();

        Swal.fire({
            text: "Here's a basic example of SweetAlert!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    });
</script>
