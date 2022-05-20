<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('.btn-deletar').click(function (e) {
        e.preventDefault();
        const form = $(this).closest('.form-deletar');
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Você não poderá reverter isso!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar',

        }).then((result) => {
            if (result.value) {
                form.submit();
                Swal.fire({
                    icon: 'success',
                    title: 'o item está sendo deletado, aguarde!',
                    showConfirmButton: false,
                    timer: 4000,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                })

            }
        })
    });
</script>
