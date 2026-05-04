function timer(configTimer) {
    let lifetime = (configTimer.timeout) * 60 * 1000;

    let timer = setTimeout(() => { window.location.reload(); }, lifetime)

    // Para reiniciar el timer con las peticiones AJAX
    const oldXHR = window.XMLHttpRequest;
    function newXHR() {
        let realXHR = new oldXHR();
        realXHR.addEventListener("readystatechange", function() {
            if (realXHR.readyState ===  realXHR.DONE) {
                clearTimeout(timer);
                timer = setTimeout(() => { window.location.reload(); }, lifetime);
            }
        }, false);
        return realXHR;
    }
    window.XMLHttpRequest = newXHR;
}

export default timer
