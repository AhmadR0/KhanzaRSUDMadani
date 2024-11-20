document.addEventListener('DOMContentLoaded', () => {
    const scrollWrapper = document.querySelector('.scroll-wrapper tbody');
    let scrollAmount = 0;

    function autoScroll() {
        scrollAmount++;
        if (scrollAmount >= scrollWrapper.scrollHeight - scrollWrapper.clientHeight) {
            scrollAmount = 0; // Reset ke posisi awal ketika mencapai bagian bawah
        }
        scrollWrapper.scrollTop = scrollAmount;
    }

    setInterval(autoScroll, 50); // Kecepatan scroll
});
