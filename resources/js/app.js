require('./bootstrap');

document.addEventListener('livewire:load', function () {
    Livewire.on('pageChanged', () => {
        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    })
});
