document.addEventListener('DOMContentLoaded', () => {
    if (isMobileDevice()) {
        document.getElementById('qrCode').style.display = 'none';
        document.getElementById('qrCodeText').style.display = 'none';
        document.getElementById('copyButton').style.display = 'block';
        document.getElementById('copyText').style.display = 'block';
    }
});

const isMobileDevice = () => {
    return /Mobi|Android/i.test(navigator.userAgent);
};

const copySecret = () => {
    navigator.clipboard.writeText(qrCodeUrl).then(() => {
        Swal.fire({
            title: 'Copied to clipboard',
            icon: 'success',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            confirmButtonText: 'Got It'
        });
    })
};