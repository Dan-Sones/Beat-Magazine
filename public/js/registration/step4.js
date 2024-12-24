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
        alert('QR Code URL copied to clipboard');
    }).catch(err => {
        console.error('Failed to copy QR Code URL: ', err);
    });
};