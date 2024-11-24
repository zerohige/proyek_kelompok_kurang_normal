document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signature-canvas');
    const signaturePad = new SignaturePad(canvas);
    const clearButton = document.getElementById('clear-signature');
    const signatureDataInput = document.getElementById('signature-data');

    // Hapus tanda tangan
    clearButton.addEventListener('click', function () {
        signaturePad.clear();
    });

    // Simpan data tanda tangan
    document.querySelector('form').addEventListener('submit', function () {
        if (!signaturePad.isEmpty()) {
            signatureDataInput.value = signaturePad.toDataURL();
        } else {
            alert("Harap mengisi tanda tangan!");
            return false;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signature-canvas');
    const signaturePad = new SignaturePad(canvas);
    const clearButton = document.getElementById('clear-signature');
    const signatureDataInput = document.getElementById('signature-data');

    // Hapus tanda tangan
    clearButton.addEventListener('click', function () {
        signaturePad.clear();
    });

    // Simpan data tanda tangan sebelum formulir dikirim
    document.querySelector('form').addEventListener('submit', function () {
        if (!signaturePad.isEmpty()) {
            signatureDataInput.value = signaturePad.toDataURL(); // Simpan data tanda tangan
        } else {
            alert("Harap mengisi tanda tangan!");
            return false;
        }
    });
});
