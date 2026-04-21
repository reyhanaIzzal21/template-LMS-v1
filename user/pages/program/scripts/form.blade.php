<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('enrollment-form');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnLoading = document.getElementById('btn-loading');
        const formErrors = document.getElementById('form-errors');
        const errorList = document.getElementById('error-list');

        function setLoading(loading) {
            submitBtn.disabled = loading;
            btnIcon.classList.toggle('hidden', loading);
            btnLoading.classList.toggle('hidden', !loading);
            btnText.textContent = loading ? 'Memproses...' : 'Lanjut Pembayaran';
        }

        function showErrors(errors) {
            errorList.innerHTML = '';
            if (typeof errors === 'string') {
                const li = document.createElement('li');
                li.textContent = errors;
                errorList.appendChild(li);
            } else if (typeof errors === 'object') {
                Object.values(errors).flat().forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
            }
            formErrors.classList.remove('hidden');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function hideErrors() {
            formErrors.classList.add('hidden');
            errorList.innerHTML = '';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            hideErrors();
            setLoading(true);

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    setLoading(false);

                    if (!data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }
                        showErrors(data.message || data.errors || 'Terjadi kesalahan.');
                        return;
                    }

                    if (data.is_free) {
                        // Free program - redirect to success
                        window.location.href = data.redirect;
                        return;
                    }

                    // Paid program - show Midtrans Snap popup
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = data.success_url + '?order_id=' +
                                data.order_id + '&status=success';
                        },
                        onPending: function(result) {
                            window.location.href = data.success_url + '?order_id=' +
                                data.order_id + '&status=pending';
                        },
                        onError: function(result) {
                            window.location.href = data.success_url + '?order_id=' +
                                data.order_id + '&status=error';
                        },
                        onClose: function() {
                            showErrors(
                                'Anda menutup popup pembayaran tanpa menyelesaikan transaksi. Silakan klik tombol untuk melanjutkan pembayaran.'
                            );
                        }
                    });
                })
                .catch(error => {
                    setLoading(false);
                    console.error('Error:', error);
                    showErrors('Terjadi kesalahan pada server. Silakan coba lagi.');
                });
        });
    });
</script>
