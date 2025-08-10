function checkIfStringOnly(event,max){
        const strRegex = /^[A-Za-z]$/;
        const charCode = event.keyCode || event.which;
        const charStr = String.fromCharCode(charCode);
        if (!strRegex.test(charStr)) {
            event.preventDefault();
        }
        if (event.target.value.length >= max) {
            event.preventDefault();
        }
}
function showToast(msg,status){
    status = status > 0 ? "#198754":"#dc3545";

    const $toast = Toastify({
        text:msg,
        duration: 3000,
        close: true,
        gravity: "top", 
        position: "right", 
        stopOnFocus: true, 
        style: {
            background:status,
        },
    });

    $toast.showToast();
}